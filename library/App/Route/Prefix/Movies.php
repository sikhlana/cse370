<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Route\Prefix;

use App\Route\Backbone;
use App\Router;

class Movies extends Backbone
{
    protected function _getRouteClasses()
    {
        return array(
            'default' => 'controller:\App\ControllerPublic\Movie',
            'schedule' => '\App\Route\Prefix\Movies\Schedule'
        );
    }

    protected function _preMatch(&$routePath, \Zend_Controller_Request_Http $request, Router $router)
    {
        $routePath = $router->resolveActionWithIntegerParam($routePath, $request, 'movie_id', 'view');
    }

    protected function _preBuildLink($originalPrefix, &$outputPrefix, &$action, $extension, &$data, array &$extraParams)
    {
        if (isset($data['movie_id']))
        {
            $outputPrefix = Router::buildBasicLinkWithIntegerParam($outputPrefix, '', '', $data, 'movie_id', 'title');
            $outputPrefix = trim($outputPrefix, '/');
        }
    }
}