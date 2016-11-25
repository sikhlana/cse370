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
use App\Upload;

class Movie extends ControllerAdmin
{
    public function actionIndex()
    {
        $movies = $this->models()->movie()->getAllMovies();
        $movies = $this->models()->movie()->prepareMovies($movies);

        $viewParams = array(
            'movies' => $movies
        );

        return $this->responseView('admin_movie_list', $viewParams);
    }

    public function actionAdd()
    {
        return $this->_getAddEditResponse(array(
            'movie_id' => null,
            'title' => '',
            'release_date' => null,
            'synopsis' => '',
            'imbd_link' => ''
        ));
    }

    public function actionEdit()
    {
        return $this->_getAddEditResponse($this->_getMovieOrError());
    }

    protected function _getAddEditResponse(array $movie, array $viewParams = array())
    {
        $viewParams += array(
            'movie' => $movie
        );

        return $this->responseView('admin_movie_edit', $viewParams);
    }

    public function actionSave()
    {
        $this->_assertPostOnly();

        $data = $this->_input->filter(array(
            'title' => Input::STRING,
            'release_date' => Input::DATE_TIME,
            'synopsis' => Input::STRING,
            'imdb_id' => Input::STRING,
            'trailer_link' => Input::STRING
        ));

        $poster = Upload::getUploadedFile('poster');
        if ($poster)
        {
            if (!$poster->isImage())
            {
                return $this->responseError('Please select a valid image as poster.');
            }
        }

        if (empty($data['title']))
        {
            return $this->responseError('Movie title cannot be empty.');
        }

        if (empty($data['imdb_id']))
        {
            return $this->responseError('IMDB ID cannot be empty.');
        }

        if (empty($data['release_date']))
        {
            return $this->responseError('Release date cannot be empty.');
        }

        if (empty($data['trailer_link']))
        {
            return $this->responseError('Please enter a Youtube link for the trailer.');
        }

        $movieId = $this->_input->filterSingle('movie_id', Input::UINT);
        $movie = $movieId ? $this->models()->movie()->getMovieById($movieId) : false;
        if ($movie)
        {
            $changes = array();

            foreach ($data as $k => $v)
            {
                if ($movie[$k] != $v)
                {
                    $changes[$k] = $v;
                }
            }

            if (!empty($changes))
            {
                $this->models()->movie()->update($movie['movie_id'], $changes);
            }
        }
        else
        {
            if (empty($poster))
            {
                return $this->responseError('Please select a poster for the movie.');
            }

            $movieId = $this->models()->movie()->insert($data);
            $movie = $this->models()->movie()->getMovieById($movieId);
        }

        if ($poster)
        {
            $this->models()->movie()->uploadMoviePoster($movie['movie_id'], $poster);
        }

        $this->models()->movie()->updateImdbData($movie['movie_id']);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('admin/movies')
        );
    }

    public function actionDelete()
    {
        $movie = $this->_getMovieOrError();
        $this->models()->movie()->delete($movie['movie_id']);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('admin/movies')
        );
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
            throw $this->responseException(
                $this->responseError('Requested movie not found.', 404)
            );
        }

        return $movie;
    }
}