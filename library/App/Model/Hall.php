<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Model;

class Hall extends Model
{
    public function getHallById($hallId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM hall
            WHERE hall_id = ?', $hallId
        );
    }

    public function getHallByName($hallName)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM hall
            WHERE hall_name = ?', $hallName
        );
    }

    public function getAllHalls()
    {
        return $this->fetchAllKeyed(
            'SELECT *
            FROM hall
            ORDER BY hall_name', 'hall_id'
        );
    }

    public function insert(array $hall)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO hall
              (hall_name, hall_type, row_count, column_count)
            VALUES
              (?, ?, ?, ?)', array($hall['hall_name'], $hall['hall_type'], $hall['row_count'], $hall['column_count'])
        );

        return $stmt->rowCount() ? $this->_getDb()->lastInsertId() : false;
    }

    public function update($hallId, array $changes)
    {
        $values = array();

        foreach ($changes as $k => $v)
        {
            $values[] = $k . ' = ' . $this->_getDb()->quote($v);
        }

        $stmt = $this->_getDb()->query(
            'UPDATE hall SET
            ' . implode(",\n", $values) . '
            WHERE hall_id = ?', $hallId
        );

        return $stmt->rowCount() ? true : false;
    }

    public function delete($hallId)
    {
        $stmt = $this->_getDb()->query(
            'DELETE FROM hall
            WHERE hall_id = ?', $hallId
        );

        return $stmt->rowCount() ? true : false;
    }

    public function getHallOptions(array $halls = null, $selectedHallId = 0)
    {
        if ($halls === null)
        {
            $halls = $this->getAllHalls();
        }

        $options = array();

        foreach ($halls as $hall)
        {
            $options[] = array(
                'value' => $hall['hall_id'],
                'label' => $hall['hall_name'],
                'selected' => $hall['hall_id'] == $selectedHallId
            );
        }

        return $options;
    }
}