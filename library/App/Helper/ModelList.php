<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Helper;

class ModelList
{
    protected $_modelCache = array();

    protected function _get($class)
    {
        $class = '\App\Model\\' . $class;

        if (!isset($this->_modelCache[$class]))
        {
            $this->_modelCache[$class] = new $class();
        }

        return $this->_modelCache[$class];
    }

    /**
     * @return \App\Model\User
     */
    public function user()
    {
        return $this->_get('User');
    }

    /**
     * @return \App\Model\Hall
     */
    public function hall()
    {
        return $this->_get('Hall');
    }

    /**
     * @return \App\Model\Movie
     */
    public function movie()
    {
        return $this->_get('Movie');
    }

    /**
     * @return \App\Model\MovieFeedback
     */
    public function feedback()
    {
        return $this->_get('MovieFeedback');
    }

    /**
     * @return \App\Model\Showtime
     */
    public function showtime()
    {
        return $this->_get('Showtime');
    }

    /**
     * @return \App\Model\Ticket
     */
    public function ticket()
    {
        return $this->_get('Ticket');
    }

    /**
     * @return \App\Model\MovieWishlist
     */
    public function wishlist()
    {
        return $this->_get('MovieWishlist');
    }

    /**
     * @return \App\Model\Order
     */
    public function order()
    {
        return $this->_get('Order');
    }

    /**
     * @return \App\Model\Invoice
     */
    public function invoice()
    {
        return $this->_get('Invoice');
    }
}