<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Model;

class Ticket extends Model
{
    public function getTicketById($ticketId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM ticket
            WHERE ticket_id = ?', $ticketId
        );
    }

    public function getAllTicketsForOrderWithMovieAndHall($orderId)
    {
        return $this->fetchAllKeyed(
            'SELECT *, movie.*, hall.*
            FROM ticket
            INNER JOIN showtime
              ON (showtime.showtime_id = ticket.showtime_id)
            INNER JOIN hall
              ON (hall.hall_id = showtime.hall_id)
            INNER JOIN movie
              ON (movie.movie_id = showtime.movie_id)
            WHERE order_id = ?', 'ticket_id', $orderId
        );
    }

    public function checkIfTicketExists($showtimeId, $seatNumber)
    {
        return $this->_getDb()->fetchOne(
            'SELECT COUNT(*)
            FROM ticket
            WHERE showtime_id = ?
            AND seat_number = ?', array($showtimeId, $seatNumber)
        );
    }

    public function removeTicketForUser($orderId, $seatNumber)
    {
        $stmt = $this->_getDb()->query(
            'DELETE FROM ticket
            WHERE order_id = ?
            AND seat_number = ?', array($orderId, $seatNumber)
        );

        return $stmt->rowCount() ? true : false;
    }

    public function createTicket($showtimeId, $orderId, $seatNumber, $ticketPrice, $ticketGrade)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO ticket
            (showtime_id, order_id, seat_number, ticket_price, ticket_grade)
            VALUES
            (?, ?, ?, ?, ?)', array($showtimeId, $orderId, $seatNumber, $ticketPrice, $ticketGrade)
        );

        if ($stmt->rowCount())
        {
            /*$showtime = $this->_getShowtimeModel()->getShowtimeById($showtimeId);
            $this->_getWishlistModel()->deleteWishlist($showtime['movie_id']);*/

            return $this->getTicketById($this->_getDb()->lastInsertId());
        }

        return false;
    }

    public function removeTicketsForOrder($orderId)
    {
        $stmt = $this->_getDb()->query(
            'DELETE FROM ticket
            WHERE order_id = ?', $orderId
        );

        return $stmt->rowCount() ? true : false;
    }

    public function buildSeatMatrix(array $hall, array $showtime, $orderId = null)
    {
        if ($orderId === null)
        {
            $disabled = $this->_getDb()->fetchCol(
                'SELECT seat_number
                FROM ticket
                WHERE showtime_id = ?', $showtime['showtime_id']
            );

            $selected = array();
        }
        else
        {
            $disabled = $this->_getDb()->fetchCol(
                'SELECT seat_number
                FROM ticket
                WHERE showtime_id = ?
                AND order_id != ?', array($showtime['showtime_id'], $orderId)
            );

            $selected = $this->_getDb()->fetchCol(
                'SELECT seat_number
                FROM ticket
                WHERE showtime_id = ?
                AND order_id = ?', array($showtime['showtime_id'], $orderId)
            );
        }

        $matrix = array();

        for ($i = 1; $i <= $hall['row_count']; $i++)
        {
            $char = chr(64 + $i);

            for ($j = 1; $j <= $hall['column_count']; $j++)
            {
                $seatNumber = $char . '-' . $j;
                $matrix[$i][$j] = array(
                    'number' => $seatNumber,
                    'disabled' => in_array($seatNumber, $disabled),
                    'selected' => in_array($seatNumber, $selected),
                    'seat_type' => $i >= ($hall['row_count'] - 4) ? 'premium' : 'regular'
                );
            }
        }

        return $matrix;
    }

    /**
     * @return Showtime
     */
    protected function _getShowtimeModel()
    {
        return $this->getModelFromCache('\App\Model\Showtime');
    }

    /**
     * @return MovieWishlist
     */
    protected function _getWishlistModel()
    {
        return $this->getModelFromCache('\App\Model\MovieWishlist');
    }
}