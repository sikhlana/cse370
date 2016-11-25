<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerAdmin;

use App\ControllerAdmin;
use App\ControllerResponse\Redirect;
use App\Router;
use App\Input;

class Schedule extends ControllerAdmin
{
    public function actionIndex()
    {
        $showtimes = $this->models()->showtime()->getAllShowtimesWithMovieAndHall();
        $showtimes = $this->models()->showtime()->prepareShowtimes($showtimes);
        $showtimes = $this->models()->movie()->prepareMovies($showtimes);

        $viewParams = array(
            'showtimes' => $showtimes
        );

        return $this->responseView('admin_schedule_list', $viewParams);
    }

    public function actionAdd()
    {
        return $this->_getAddEditResponse(array(
            'showtime_id' => null,
            'showtime_date' => \App::$time,
            'showtime_time' => 39600,
            'movie_id' => '',
            'hall_id' => ''
        ));
    }

    public function actionEdit()
    {
        return $this->_getAddEditResponse($this->_getShowtimeOrError());
    }

    protected function _getAddEditResponse(array $showtime, array $viewParams = array())
    {
        $movies = $this->models()->movie()->getAllMovies();
        $movieOptions = $this->models()->movie()->getMovieOptions($movies, $showtime['movie_id']);
        $halls = $this->models()->hall()->getAllHalls();
        $hallOptions = $this->models()->hall()->getHallOptions($halls, $showtime['hall_id']);

        $viewParams += array(
            'showtime' => $showtime,
            'movies' => $movieOptions,
            'halls' => $hallOptions,
            'timing' => $this->models()->showtime()->getStartTimeOptions($showtime['showtime_time'])
        );

        return $this->responseView('admin_schedule_edit', $viewParams);
    }

    public function actionSave()
    {
        $this->_assertPostOnly();

        $data = $this->_input->filter(array(
            'movie_id' => Input::UINT,
            'hall_id' => Input::UINT,
            'showtime_date' => Input::DATE_TIME
        ));

        $showTime = $this->_input->filterSingle('showtime_time', Input::UINT);
        $data['showtime_date'] += $showTime;

        if ($data['showtime_date'] < \App::$time)
        {
            return $this->responseError('Please select a valid time.');
        }

        $showtimeId = $this->_input->filterSingle('showtime_id', Input::UINT);
        $showtime = $this->models()->showtime()->getShowtimeById($showtimeId);
        if ($showtime)
        {
            $changes = array();

            foreach ($data as $k => $v)
            {
                if ($showtime[$k] != $v)
                {
                    $changes[$k] = $v;
                }
            }

            if (isset($changes['showtime_date']) || isset($changes['hall_id']))
            {
                if ($this->models()->showtime()->checkIfShowtimeExists($data['hall_id'], $data['showtime_date']))
                {
                    return $this->responseError('The hall is already booked for another show for that timing.');
                }
            }

            if (!empty($changes))
            {
                $this->models()->showtime()->update($showtime['showtime_id'], $changes);
            }
        }
        else
        {
            if ($this->models()->showtime()->checkIfShowtimeExists($data['hall_id'], $data['showtime_date']))
            {
                return $this->responseError('The hall is already booked for another show for that timing.');
            }

            $this->models()->showtime()->insert($data);
        }

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('admin/schedule')
        );
    }

    public function actionDelete()
    {
        $showtime = $this->_getShowtimeOrError();
        $this->models()->showtime()->delete($showtime['showtime_id']);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('admin/schedule')
        );
    }

    protected function _getShowtimeOrError($showtimeId = null)
    {
        if ($showtimeId === null)
        {
            $showtimeId = $this->_input->filterSingle('showtime_id', Input::UINT);;
        }

        $showtime = $this->models()->showtime()->getShowtimeById($showtimeId);
        if (!$showtime)
        {
            throw $this->responseException(
                $this->responseError('Requested showtime cannot be found.', 404)
            );
        }

        return $this->models()->showtime()->prepareShowtime($showtime);
    }
}