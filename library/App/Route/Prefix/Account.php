<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Route\Prefix;

use App\Route\Backbone;

class Account extends Backbone
{
    protected function _getRouteClasses()
    {
        return array(
            'default' => 'controller:\App\ControllerPublic\Account',
            'invoices' => '\App\Route\Prefix\Account\Invoices'
        );
    }
}