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

class Register extends ControllerPublic
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

        $this->_setMajorSection('register');
    }

    public function actionIndex()
    {
        return $this->responseView('register');
    }

    public function actionRegister()
    {
        $this->_assertPostOnly();

        $data = $this->_input->filter(array(
            'username' => Input::STRING,
            'first_name' => Input::STRING,
            'last_name' => Input::STRING
        ));

        $password = $this->_input->filterSingle('password', Input::STRING);
        $passwordConfirm = $this->_input->filterSingle('password_confirm', Input::STRING);

        if (!self::isEmailValid($data['username']))
        {
            return $this->responseError('Please enter a valid email address.');
        }

        if ($password !== $passwordConfirm)
        {
            return $this->responseError('The confirmation password did not match.');
        }

        if ($this->models()->user()->getUserByName($data['username']))
        {
            return $this->responseError('Email addresses need to be unique. Another account is using this email address.');
        }

        if ($this->models()->user()->insert($data, $password) > 0)
        {
            $user = $this->models()->user()->getUserByName($data['username']);
            \App::getSession()->set('user', $user);
        }

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('account/billing'),
            'You have successfully registered.'
        );
    }

    public static function isEmailValid($email)
    {
        $validator = new \Zend_Validate_EmailAddress();
        $validator->getHostnameValidator()->setValidateTld(false)->setValidateIdn(false);

        return $validator->isValid($email);
    }
}