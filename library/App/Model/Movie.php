<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Helper\File;
use App\Helper\Image;
use App\Model;
use App\Upload;

class Movie extends Model
{
    public function getMovieById($movieId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM movie
            WHERE movie_id = ?', $movieId
        );
    }

    public function getMovieByTitle($title)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM movie
            WHERE title = ?', $title
        );
    }

    public function getAllMovies()
    {
        return $this->fetchAllKeyed(
            'SELECT *
            FROM movie
            ORDER BY release_date DESC, title ASC', 'movie_id'
        );
    }

    public function getAllMoviesWithAvailableShowtime()
    {
        return $this->fetchAllKeyed(
            'SELECT movie.*, showtime.*
            FROM movie
            INNER JOIN showtime
              ON (movie.movie_id = showtime.movie_id AND showtime_date > ?)
            ORDER BY movie.release_date DESC, movie.title ASC', 'movie_id', \App::$time
        );
    }

    public function getAllUpcomingMovies()
    {
        return $this->fetchAllKeyed(
            'SELECT movie.*
            FROM movie
            WHERE release_date > ?
            ORDER BY release_date DESC, title ASC', 'movie_id', \App::$time
        );
    }

    public function getAllMoviesAndCheckForAvailableShowtime()
    {
        return $this->fetchAllKeyed(
            'SELECT movie.*,
            IF((SELECT COUNT(*) FROM showtime WHERE showtime.movie_id = movie.movie_id AND showtime_date > ?) > 0, 1, 0) AS has_showtime
            FROM movie
            ORDER BY has_showtime DESC, release_date DESC, title ASC', 'movie_id', \App::$time
        );
    }

    public function prepareMovie(array $movie)
    {
        $movie['posterUrl'] = 'data/posters/' . md5($movie['movie_id']) . '.jpg';
        $movie['thumbUrl'] = 'data/posters/' . md5($movie['movie_id']) . '-thumb.jpg';

        $movie['imdbData'] = @unserialize($movie['imdb_data']);
        $runtime = $movie['imdbData']['Runtime'];
        $movie['runtime'] = array(
            'hours' => floor($runtime /  60),
            'minutes' => $runtime % 60
        );

        $movie['youtubeId'] = str_replace('v=', '', parse_url($movie['trailer_link'], PHP_URL_QUERY));

        return $movie;
    }

    public function prepareMovies(array $movies)
    {
        foreach ($movies as &$movie)
        {
            $movie = $this->prepareMovie($movie);
        }

        return $movies;
    }

    public function insert(array $movie)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO movie
              (title, release_date, synopsis, imdb_id, trailer_link)
            VALUES
              (?, ?, ?, ?, ?)', array($movie['title'], $movie['release_date'], $movie['synopsis'], $movie['imdb_id'], $movie['trailer_link'])
        );

        return $stmt->rowCount() ? $this->_getDb()->lastInsertId() : false;
    }

    public function update($movieId, array $changes)
    {
        $values = array();

        foreach ($changes as $k => $v)
        {
            $values[] = $k . ' = ' . $this->_getDb()->quote($v);
        }

        $stmt = $this->_getDb()->query(
            'UPDATE movie SET
            ' . implode(",\n", $values) . '
            WHERE movie_id = ?', $movieId
        );

        return $stmt->rowCount() ? true : false;
    }

    public function delete($movieId)
    {
        $stmt = $this->_getDb()->query(
            'DELETE FROM movie
            WHERE movie_id = ?', $movieId
        );

        if ($stmt->rowCount())
        {
            @unlink ($this->getMoviePosterPath($movieId));
            @unlink($this->getMoviePosterThumbPath($movieId));
            return true;
        }

        return false;
    }

    public function uploadMoviePoster($movieId, Upload $file)
    {
        $fileName = $this->getMoviePosterPath($movieId);
        File::createDirectory(dirname($fileName), true);

        $image = Image::createFromFileDirect($file->getTempFile(), $file->getImageInfoField('type'));
        $image->output(IMAGETYPE_JPEG, $fileName, 100);

        $thumbnail = $this->getMoviePosterThumbPath($movieId);
        $image->thumbnailFixedShorterSide(200);
        $image->output(IMAGETYPE_JPEG, $thumbnail, 100);
    }

    public function getMoviePosterPath($movieId)
    {
        return \App::getRegistry()->get('rootDir') . '/data/posters/' . md5($movieId) . '.jpg';
    }

    public function getMoviePosterThumbPath($movieId)
    {
        return \App::getRegistry()->get('rootDir') . '/data/posters/' . md5($movieId) . '-thumb.jpg';
    }

    public function getMovieOptions(array $movies = null, $selectedMovieId = 0)
    {
        if ($movies === null)
        {
            $movies = $this->getAllMovies();
        }

        $options = array();

        foreach ($movies as $movie)
        {
            $options[] = array(
                'value' => $movie['movie_id'],
                'label' => $movie['title'],
                'selected' => $movie['movie_id'] == $selectedMovieId
            );
        }

        return $options;
    }

    public function updateImdbData($movieId)
    {
        $imdbId = $this->_getDb()->fetchOne('SELECT imdb_id FROM movie WHERE movie_id = ?', $movieId);
        if (!$imdbId)
        {
            return;
        }

        $client = new \Zend_Http_Client();
        $client->setUri('http://www.omdbapi.com/');
        $client->setParameterGet('i', $imdbId);

        $response = $client->request();
        if ($response->isSuccessful())
        {
            $json = @json_decode($response->getBody(), true);
            if ($json)
            {
                $this->_getDb()->query(
                    'UPDATE movie
                    SET imdb_data = ?
                    WHERE movie_id = ?', array(serialize($json), $movieId)
                );
            }
        }
    }
}