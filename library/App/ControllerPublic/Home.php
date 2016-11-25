<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerPublic;

use App\ControllerPublic;

class Home extends ControllerPublic
{
    protected function _preDispatch($action)
    {
        $this->_setMajorSection('home');
    }

    public function actionIndex()
    {
        $ongoingMovies = $this->models()->movie()->getAllMoviesWithAvailableShowtime();
        $ongoingMovies = $this->models()->movie()->prepareMovies($ongoingMovies);

        $upcomingMovies = $this->models()->movie()->getAllUpcomingMovies();
        $upcomingMovies = $this->models()->movie()->prepareMovies($upcomingMovies);

        $viewParams = array(
            'ongoingMovies' => $ongoingMovies,
            'upcomingMovies' => $upcomingMovies
        );

        return $this->responseView('home', $viewParams);
    }
}