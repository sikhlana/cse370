<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Route\PrefixAdmin;

use App\Route\BuildInterface;
use App\Route\MatchInterface;
use App\Router;

class Schedule implements MatchInterface, BuildInterface
{
    public function match($routePath, \Zend_Controller_Request_Http $request, Router $router)
    {
        $action = $router->resolveActionWithIntegerParam($routePath, $request, 'showtime_id');
        return array('controller' => '\App\ControllerAdmin\Schedule', 'action' => $action);
    }

    public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        return Router::buildBasicLinkWithIntegerParam($outputPrefix, $action, $extension, $data, 'showtime_id');
    }
}