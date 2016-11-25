<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App;

class Model
{
    protected $_db;

    protected $_modelCache = array();

    /**
     * @return \Zend_Db_Adapter_Abstract
     */
    protected function _getDb()
    {
        if (!$this->_db)
        {
            $this->_db = \App::getDb();
        }

        return $this->_db;
    }

    public function fetchAllKeyed($sql, $key, $bind = array(), $nullPrefix = '')
    {
        $results = array();
        $i = 0;

        $stmt = $this->_getDb()->query($sql, $bind, \Zend_Db::FETCH_ASSOC);
        while ($row = $stmt->fetch())
        {
            $i++;
            $results[(isset($row[$key]) ? $row[$key] : $nullPrefix . $i)] = $row;
        }

        return $results;
    }

    public function getModelFromCache($class)
    {
        if (!isset($this->_modelCache[$class]))
        {
            $this->_modelCache[$class] = new $class();
        }

        return $this->_modelCache[$class];
    }
}