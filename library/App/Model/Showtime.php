<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Locale;
use App\Model;

class Showtime extends Model
{
    public function getShowtimeById($showtimeId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM showtime
            WHERE showtime_id = ?', $showtimeId
        );
    }

    public function getAllShowtimes()
    {
        return $this->fetchAllKeyed(
            'SELECT *
            FROM showtime
            ORDER BY showtime_date DESC', 'showtime_id'
        );
    }

    public function getAllShowtimesWithMovieAndHall()
    {
        return $this->fetchAllKeyed(
            'SELECT showtime.*, hall.hall_name, hall.hall_type, movie.title AS movie_title, movie.release_date, movie.imdb_data, movie.trailer_link
            FROM showtime
            INNER JOIN movie
              ON (movie.movie_id = showtime.movie_id)
            INNER JOIN hall
              ON (hall.hall_id = showtime.hall_id)
            ORDER BY showtime_date DESC', 'showtime_id'
        );
    }

    public function getAvailableShowtimesForMovie($movieId)
    {
        return $this->fetchAllKeyed(
            'SELECT showtime.*, hall.*
            FROM showtime
            INNER JOIN hall
              ON (hall.hall_id = showtime.hall_id)
            WHERE movie_id = ?
            AND showtime_date > ?
            ORDER BY showtime_date ASC', 'showtime_id', array($movieId, \App::$time)
        );
    }

    public function checkIfShowtimeExists($hallId, $showTime)
    {
        return $this->_getDb()->fetchOne(
            'SELECT COUNT(*)
            FROM showtime
            WHERE hall_id = ?
            AND showtime_date = ?', array($hallId, $showTime)
        );
    }

    public function prepareShowtime(array $showtime, array $movie = null)
    {
        $showtime['preparedDate'] = Locale::date($showtime['showtime_date']);
        $showtime['preparedTime'] = Locale::time($showtime['showtime_date']);

        $dt = new \DateTime('@' . $showtime['showtime_date']);
        $dt->setTimezone(Locale::getDefaultTimeZone());
        $showtime['showtime_time'] = intval($dt->format('G')) * 3600;

        if (isset($movie['title']))
        {
            $showtime['title'] = $movie['title'];
        }

        return $showtime;
    }

    public function prepareShowtimes(array $showtimes, array $movie = null)
    {
        foreach ($showtimes as &$showtime)
        {
            $showtime = $this->prepareShowtime($showtime, $movie);
        }

        return $showtimes;
    }

    public function groupShowtimes(array $showtimes)
    {
        $grouped = array();

        foreach ($showtimes as $showtime)
        {
            if (!isset($grouped[$showtime['preparedDate']][$showtime['hall_id']]))
            {
                $grouped[$showtime['preparedDate']][$showtime['hall_id']] = array(
                    'hall_name' => $showtime['hall_name'],
                    'hall_type' => $showtime['hall_type'],
                    'showtimes' => array()
                );
            }

            $grouped[$showtime['preparedDate']][$showtime['hall_id']]['showtimes'][] = $showtime;
        }

        return $grouped;
    }

    public function getStartTimeOptions($selectedTime)
    {
        $timing = array(39600 => '11:00 AM', 50400 => '2:00 PM', 61200 => '5:00 PM', 72000 => '8:00 PM');
        $options = array();

        foreach ($timing as $i => $v)
        {
            $options[] = array(
                'value' => $i,
                'label' => $v,
                'selected' => $i == $selectedTime
            );
        }

        return $options;
    }

    public function insert(array $showtime)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO showtime
              (showtime_date, movie_id, hall_id)
            VALUES
             (?, ?, ?)', array($showtime['showtime_date'], $showtime['movie_id'], $showtime['hall_id'])
        );

        return $stmt->rowCount() ? $this->_getDb()->lastInsertId() : false;
    }

    public function update($showtimeId, array $changes)
    {
        $values = array();

        foreach ($changes as $k => $v)
        {
            $values[] = $k . ' = ' . $this->_getDb()->quote($v);
        }

        $stmt = $this->_getDb()->query(
            'UPDATE showtime SET
            ' . implode(",\n", $values) . '
            WHERE showtime_id = ?', $showtimeId
        );

        return $stmt->rowCount() ? true : false;
    }

    public function delete($showtimeId)
    {
        $stmt = $this->_getDb()->query(
            'DELETE FROM showtime
            WHERE showtime_id = ?', $showtimeId
        );

        return $stmt->rowCount() ? true : false;
    }
}