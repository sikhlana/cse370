<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Route\Prefix\Account;

use App\Router;
use App\Route\BuildInterface;
use App\Route\MatchInterface;

class Invoices implements MatchInterface, BuildInterface
{
    public function match($routePath, \Zend_Controller_Request_Http $request, Router $router)
    {
        $action = $router->resolveActionWithIntegerParam($routePath, $request, 'invoice_id');
        return array('controller' => '\App\ControllerPublic\Account\Invoice', 'action' => $action);
    }

    public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        return Router::buildBasicLinkWithIntegerParam($outputPrefix, $action, $extension, $data, 'invoice_id');
    }
}