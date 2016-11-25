<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Model;

use App\Model;

class Invoice extends Model
{
    public function getInvoiceById($invoiceId)
    {
        return $this->_getDb()->fetchRow(
            'SELECT *
            FROM invoice
            WHERE invoice_id = ?', $invoiceId
        );
    }

    public function createInvoice(array $order, $totalPrice, $discount)
    {
        $stmt = $this->_getDb()->query(
            'INSERT INTO invoice
            (order_id, user_id, total, discount, invoice_date, payment_date, payment_method, invoice_status)
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)', array(
                $order['order_id'], $order['user_id'], $totalPrice, $discount, \App::$time, 0, '', 'pending'
            )
        );

        if ($stmt->rowCount())
        {
            return $this->getInvoiceById($this->_getDb()->lastInsertId());
        }

        return false;
    }

    public function markInvoiceAsPaid($invoiceId, $paymentMethod = 'manual')
    {
        $stmt = $this->_getDb()->query(
            'UPDATE invoice
            SET payment_date = ?,
            payment_method = ?,
            invoice_status = \'paid\'
            WHERE invoice_id = ?', array(\App::$time, $paymentMethod, $invoiceId)
        );

        return $stmt->rowCount() ? true : false;
    }
}