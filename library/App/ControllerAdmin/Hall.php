<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerAdmin;

use App\ControllerAdmin;
use App\ControllerResponse\Redirect;
use App\Router;
use App\Input;

class Hall extends ControllerAdmin
{
    public function actionIndex()
    {
        $halls = $this->models()->hall()->getAllHalls();

        $viewParams = array(
            'halls' => $halls
        );

        return $this->responseView('admin_hall_list', $viewParams);
    }

    public function actionAdd()
    {
        return $this->_getAddEditResponse(array(
            'hall_id' => null,
            'hall_name' => '',
            'hall_type' => '2D',
            'row_count' => 0,
            'column_count' => 0
        ));
    }

    public function actionEdit()
    {
        return $this->_getAddEditResponse($this->_getHallOrError());
    }

    protected function _getAddEditResponse(array $hall, array $viewParams = array())
    {
        $viewParams += array(
            'hall' => $hall
        );

        return $this->responseView('admin_hall_edit', $viewParams);
    }

    public function actionSave()
    {
        $this->_assertPostOnly();

        $data = $this->_input->filter(array(
            'hall_name' => Input::STRING,
            'hall_type' => Input::STRING,
            'row_count' => Input::UINT,
            'column_count' => Input::UINT
        ));

        if (empty($data['hall_name']))
        {
            return $this->responseError('Please enter a valid hall name.');
        }

        if (empty($data['row_count']) || empty($data['column_count']))
        {
            return $this->responseError('The hall cannot be empty.');
        }

        $hallId = $this->_input->filterSingle('hall_id', Input::UINT);
        $hall = $hallId ? $this->models()->hall()->getHallById($hallId) : false;
        if ($hall)
        {
            $changes = array();

            foreach ($data as $k => $v)
            {
                if ($hall[$k] != $v)
                {
                    $changes[$k] = $v;
                }
            }

            if (!empty($changes))
            {
                if (!empty($changes['hall_name']))
                {
                    if ($this->models()->hall()->getHallByName($hall['hall_name']))
                    {
                        return $this->responseError('Hall name must be unique.');
                    }
                }

                $this->models()->hall()->update($hall['hall_id'], $changes);
            }
        }
        else
        {
            if ($this->models()->hall()->getHallByName($hall['hall_name']))
            {
                return $this->responseError('Hall name must be unique.');
            }

            $this->models()->hall()->insert($data);
        }

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('admin/halls')
        );
    }

    public function actionDelete()
    {
        $hall = $this->_getHallOrError();
        $this->models()->hall()->delete($hall['hall_id']);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('admin/halls')
        );
    }

    protected function _getHallOrError($hallId = null)
    {
        if ($hallId === null)
        {
            $hallId = $this->_input->filterSingle('hall_id', Input::UINT);
        }

        $hall = $this->models()->hall()->getHallById($hallId);
        if (!$hall)
        {
            throw $this->responseException(
                $this->responseError('Requested hall not found.', 404)
            );
        }

        return $hall;
    }
}