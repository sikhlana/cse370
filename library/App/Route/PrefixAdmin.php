<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Route;

class PrefixAdmin extends Backbone
{
    protected function _getRouteClasses()
    {
        return array(
            'halls' => '\App\Route\PrefixAdmin\Halls',
            'movies' => '\App\Route\PrefixAdmin\Movies',
            'schedule' => '\App\Route\PrefixAdmin\Schedule'
        );
    }
}