<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerPublic;

use App\ControllerPublic;
use App\Input;

class MovieSchedule extends ControllerPublic
{
    protected $_movie;

    protected function _preDispatch($action)
    {
        $this->_movie = $this->_getMovieOrError();
    }

    public function actionIndex()
    {
        $movie = $this->models()->movie()->prepareMovie($this->_movie);
        $showtimes = $this->models()->showtime()->getAvailableShowtimesForMovie($movie['movie_id']);

        if (!$showtimes)
        {
            return $this->responseError('No available showtime found for the requested movie.', 404);
        }

        $showtimes = $this->models()->showtime()->prepareShowtimes($showtimes);

        $viewParams = array(
            'movie' => $movie,
            'showtimesGrouped' => $this->models()->showtime()->groupShowtimes($showtimes)
        );

        return $this->responseView('showtime_list', $viewParams);
    }

    public function actionView()
    {
        $showtime = $this->_getShowtimeOrError();
        $showtime = $this->models()->showtime()->prepareShowtime($showtime);

        $movie = $this->models()->movie()->prepareMovie($this->_movie);
        $hall = $this->models()->hall()->getHallById($showtime['hall_id']);

        $order = \App::getSession()->get('order');
        $orderId = $order ? $order['order_id'] : null;

        $seatMatrix = $this->models()->ticket()->buildSeatMatrix($hall, $showtime, $orderId);

        $columns = $hall['column_count'];
        $rows = $hall['row_count'];

        $columnSplit = floor($columns / 3);
        $rowSplit = floor($rows / 3);

        $viewParams = array(
            'showtime' => $showtime,
            'hall' => $hall,
            'seatMatrix' => $seatMatrix,
            'movie' => $movie,
            'splits' => array(
                'column' => array($columnSplit, $columns - $columnSplit),
                'row' => array($rowSplit, $rows - $rowSplit)
            ),
        );

        return $this->responseView('showtime_view', $viewParams);
    }

    public function actionSelectSeat()
    {
        $this->_assertPostOnly();
        $showtime = $this->_getShowtimeOrError();
        $user = \App::getSession()->get('user');

        if (!$user)
        {
            return $this->responseError('Please login to continue.');
        }

        $order = \App::getSession()->get('order');
        if (!$order)
        {
            $order = $this->models()->order()->createOrder($user['user_id']);
            if (!$order)
            {
                return $this->responseError('Unable to create order.');
            }
        }

        $removed = false;
        $seatNumber = $this->_input->filterSingle('seat_number', Input::STRING);

        if ($this->models()->ticket()->checkIfTicketExists($showtime['showtime_id'], $seatNumber))
        {
            $removed = $this->models()->ticket()->removeTicketForUser($order['order_id'], $seatNumber);
            if (!$removed)
            {
                return $this->responseError('The seat is already booked.');
            }
            else
            {
                unset ($order['tickets'][$seatNumber]);
            }
        }

        if (!$removed)
        {
            $ticketGrade = $this->_input->filterSingle('ticket_grade', Input::STRING);
            $ticketPrice = $this->_input->filterSingle('ticket_price', Input::UINT);

            $ticket = $this->models()->ticket()->createTicket($showtime['showtime_id'], $order['order_id'], $seatNumber, $ticketPrice, $ticketGrade);
            if (!$ticket)
            {
                return $this->responseError('Unable to create ticket.');
            }

            if (!isset($order['tickets']))
            {
                $order['tickets'] = array();
            }

            $order['tickets'][$ticket['seat_number']] = $ticket;
        }

        $viewParams = array(
            'removed' => $removed
        );

        if (empty($order['tickets']))
        {
            $this->models()->order()->deleteOrder($order['order_id'], true);
            \App::getSession()->remove('order');
        }
        else
        {
            \App::getSession()->set('order', $order);
        }

        return $this->responseAjax($viewParams);
    }

    protected function _getShowtimeOrError($showtimeId = null)
    {
        if ($showtimeId === null)
        {
            $showtimeId = $this->_input->filterSingle('showtime_id', Input::UINT);
        }

        $showtime = $this->models()->showtime()->getShowtimeById($showtimeId);
        if (!$showtime || $showtime['movie_id'] != @$this->_movie['movie_id'])
        {
            throw $this->responseException($this->responseNotFound('Requested showtime not found.'));
        }

        return $showtime;
    }

    protected function _getMovieOrError($movieId = null)
    {
        if ($movieId === null)
        {
            $movieId = $this->_input->filterSingle('movie_id', Input::UINT);
        }

        $movie = $this->models()->movie()->getMovieById($movieId);
        if (!$movie)
        {
            throw $this->responseException($this->responseNotFound('Requested movie not found.'));
        }

        return $movie;
    }
}