<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Model;

class Order extends Model
{
    public function getOrderById($orderId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM `order`
            WHERE order_id = ?', $orderId
        );
    }

    public function getOrdersWithInvoiceForUser($userId)
    {
        return $this->fetchAllKeyed(
            'SELECT `order`.*, invoice.*
            FROM `order`
            INNER JOIN invoice
              ON (invoice.order_id = `order`.order_id)
            WHERE `order`.user_id = ?
            ORDER BY order_date DESC', 'order_id', $userId
        );
    }

    public function createOrder($userId)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO `order`
            (user_id, order_date)
            VALUES
            (?, ?)', array($userId, \App::$time)
        );

        if ($stmt->rowCount())
        {
            return $this->getOrderById($this->_getDb()->lastInsertId());
        }

        return false;
    }

    public function deleteOrder($orderId, $bypassCheck = false)
    {
        if ($this->_getTicketModel()->removeTicketsForOrder($orderId) || $bypassCheck)
        {
            $this->_getDb()->query(
                'DELETE FROM `order`
                    WHERE order_id = ?', $orderId
            );
        }
    }

    public function clearExpiredOrders()
    {
        $orderIds = $this->_getDb()->fetchCol(
            'SELECT `order`.order_id
            FROM `order`
            LEFT JOIN invoice
              ON (`order`.order_id = invoice.order_id)
            WHERE invoice_id IS NULL
            AND order_date < ?', \App::$time - 3600
        );

        if (empty($orderIds))
        {
            return;
        }

        foreach ($orderIds as $orderId)
        {
            $this->deleteOrder($orderId);
        }
    }

    /**
     * @return Ticket
     */
    protected function _getTicketModel()
    {
        return $this->getModelFromCache('\App\Model\Ticket');
    }
}