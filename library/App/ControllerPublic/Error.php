<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerPublic;

use App\ControllerPublic;

class Error extends ControllerPublic
{
    public function actionErrorNotFound()
    {
        return $this->responseError('Requested path could not be found.', 404);
    }

    public function actionErrorServer()
    {
        return $this->responseError('The system is having some difficulties processing the request.', 500);
    }
}