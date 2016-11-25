<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerPublic;

use App\ControllerPublic;
use App\ControllerResponse\Redirect;
use App\Input;
use App\Router;

class Movie extends ControllerPublic
{
    protected function _preDispatch($action)
    {
        $this->_setMajorSection('movies');
    }

    public function actionIndex()
    {
        $movies = $this->models()->movie()->getAllMoviesAndCheckForAvailableShowtime();
        $movies = $this->models()->movie()->prepareMovies($movies);

        $viewParams = array(
            'movies' => $movies
        );

        return $this->responseView('movie_list', $viewParams);
    }

    public function actionView()
    {
        $movie = $this->_getMovieOrError();
        $movie = $this->models()->movie()->prepareMovie($movie);

        $showtimes = $this->models()->showtime()->getAvailableShowtimesForMovie($movie['movie_id']);
        $showtimes = $this->models()->showtime()->prepareShowtimes($showtimes, $movie);

        $hasInWishlist = false;
        $canPostFeedback = false;

        $feedbacks = $this->models()->feedback()->getAllFeedbackForMovie($movie['movie_id']);
        $feedbacks = $this->models()->feedback()->prepareFeedbacks($feedbacks);
        $feedbackAvg = $this->models()->feedback()->getFeedbackAvgForMovie($movie['movie_id']);

        if ($user = \App::getSession()->get('user'))
        {
            $hasInWishlist = $this->models()->wishlist()->hasMovieInWishlist($user['user_id'], $movie['movie_id']);
            $canPostFeedback = $this->models()->feedback()->canPostFeedback($user['user_id'], $movie['movie_id']);
        }

        $viewParams = array(
            'movie' => $movie,
            'showtimesGrouped' => $this->models()->showtime()->groupShowtimes($showtimes),
            'feedbacks' => $feedbacks,

            'hasInWishlist' => $hasInWishlist,
            'feedbackAvg' => $feedbackAvg,
            'canPostFeedback' => $canPostFeedback
        );

        return $this->responseView('movie_view', $viewParams);
    }

    public function actionReview()
    {
        $this->_assertPostOnly();
        $movie = $this->_getMovieOrError();

        $user = \App::getSession()->get('user');
        if (!$user)
        {
            return $this->responseNoPermission();
        }

        if (!$this->models()->feedback()->canPostFeedback($user['user_id'], $movie['movie_id']))
        {
            return $this->responseNoPermission();
        }

        $data = $this->_input->filter(array(
            'rating' => Input::UINT,
            'comment' => Input::STRING
        ));

        $data['user_id'] = $user['user_id'];
        $data['movie_id'] = $movie['movie_id'];

        $this->models()->feedback()->insert($data);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('movies', $movie),
            'Your review has been successfully posted.'
        );
    }

    public function actionWishlist()
    {
        $user = \App::getSession()->get('user');
        if (!$user)
        {
            return $this->responseNoPermission();
        }

        $movie = $this->_getMovieOrError();
        $movie = $this->models()->movie()->prepareMovie($movie);
        $this->models()->wishlist()->addMovieToWishlist($user['user_id'], $movie['movie_id']);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('movies', $movie)
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
                $this->responseNotFound('Requested movie not found.')
            );
        }

        return $movie;
    }
}