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

class Login extends ControllerPublic
{
    protected function _preDispatch($action)
    {
        $user = \App::getSession()->get('user');
        if (!empty($user['user_id']))
        {
            throw $this->responseException(
                $this->responseNoPermission()
            );
        }

        $this->_setMajorSection('login');
    }

    public function actionIndex()
    {
        return $this->responseView('login');
    }

    public function actionLogin()
    {
        $this->_assertPostOnly();

        $data = $this->_input->filter(array(
            'username' => Input::STRING,
            'password' => Input::STRING
        ));

        $user = $this->models()->user()->authorize($data['username'], $data['password']);
        if (!$user)
        {
            return $this->responseError('Invalid username/password combination.', 400);
        }

        \App::getSession()->set('user', $user);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('index'),
            'You have successfully logged in.'
        );
    }
}