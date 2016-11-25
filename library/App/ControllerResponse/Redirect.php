<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerResponse;

use App\ControllerResponse;

class Redirect extends ControllerResponse
{
    const RESOURCE_CANONICAL = 1;
    const RESOURCE_CANONICAL_PERMANENT = 2;
    const SUCCESS = 3;

    public $redirectType = 3;

    public $redirectTarget = '';

    public $redirectMessage = '';
}