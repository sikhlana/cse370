<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerResponse;

class Exception extends \Exception
{
    protected $_controllerResponse;

    public function setControllerResponse(\App\ControllerResponse $controllerResponse)
    {
        $this->_controllerResponse = $controllerResponse;
    }

    public function getControllerResponse()
    {
        return $this->_controllerResponse;
    }
}