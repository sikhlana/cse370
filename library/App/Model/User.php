<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Helper\Country;
use App\Model;

class User extends Model
{
    public function getUserById($userId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM user
            WHERE user_id = ?', $userId
        );
    }

    public function getUserByName($username)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM user
            WHERE username = ?', $username
        );
    }

    public function authorize($username, $password)
    {
        $user = $this->getUserByName($username);
        if (!$user)
        {
            return false;
        }

        if ($user['password_hash'] !== $this->getPasswordHash($password, $user['password_salt']))
        {
            return false;
        }

        return $user;
    }

    public function insert(array $user, $password)
    {
        $user['password_salt'] = $this->generatePasswordSalt();
        $user['password_hash'] = $this->getPasswordHash($password, $user['password_salt']);

        $stmt = $this->_getDb()->query(
            'INSERT INTO user
              (username, password_hash, password_salt, first_name, last_name)
            VALUES
              (?, ?, ?, ?, ?)', array($user['username'], $user['password_hash'], $user['password_salt'], $user['first_name'], $user['last_name'])
        );

        return $stmt->rowCount();
    }

    public function getPasswordHash($password, $salt)
    {
        return hash_hmac('sha1', $password, hash_hmac('md5', $salt, \App::GLOBAL_SALT));
    }

    public function update($userId, array $changes)
    {
        $values = array();

        foreach ($changes as $k => $v)
        {
            $values[] = $k . ' = ' . $this->_getDb()->quote($v);
        }

        $stmt = $this->_getDb()->query(
            'UPDATE user SET
            ' . implode(",\n", $values) . '
            WHERE user_id = ?', $userId
        );

        return $stmt->rowCount() ? true : false;
    }

    public function generatePasswordSalt()
    {
        do
        {
            $salt = \App::generateRandomString(40);
        }
        while ($this->_getDb()->fetchOne('SELECT COUNT(*) FROM user WHERE password_salt = ?', $salt));

        return $salt;
    }

    public function getCountryOptions($selectedCountryCode = '')
    {
        $countries = Country::getAllCountries();
        $options = array();

        foreach ($countries as $code => $country)
        {
            $options[] = array(
                'value' => $code,
                'label' => $country,
                'selected' => $code == $selectedCountryCode
            );
        }

        return $options;
    }
}