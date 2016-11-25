<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App;

class Session
{
    protected $_data;

    public function __construct()
    {
        session_start(array('name' => '__sess'));
        $this->_data = &$_SESSION;
    }

    public function get($key)
    {
        if (isset($this->_data[$key]))
        {
            return $this->_data[$key];
        }

        return null;
    }

    public function set($key, $value)
    {
        if ($value === null)
        {
            $this->remove($key);
            return;
        }

        $this->_data[$key] = $value;
    }

    public function remove($key)
    {
        unset ($this->_data[$key]);
    }

    public function toArray()
    {
        return $this->_data;
    }

    public function kill()
    {
        session_destroy();
    }
}