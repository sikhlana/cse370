<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\ControllerPublic\Account;

use App\ControllerPublic;
use App\Input;

class Invoice extends ControllerPublic
{
    protected $_user;

    protected function _preDispatch($action)
    {
        $this->_setMajorSection('account');

        $user = \App::getSession()->get('user');
        if (empty($user['user_id']))
        {
            throw $this->responseException(
                $this->responseNoPermission()
            );
        }

        $this->_user = $user;
    }

    public function actionPrintTickets()
    {
        $invoice = $this->_getInvoiceOrError();
        $tickets = $this->models()->ticket()->getAllTicketsForOrderWithMovieAndHall($invoice['order_id']);
        $tickets = $this->models()->showtime()->prepareShowtimes($tickets);

        $viewParams = array(
            'tickets' => $tickets
        );

        return $this->responseView('account_invoice_print_ticket', $viewParams);
    }

    protected function _getInvoiceOrError($invoiceId = null)
    {
        if ($invoiceId === null)
        {
            $invoiceId = $this->_input->filterSingle('invoice_id', Input::UINT);
        }

        $invoice = $this->models()->invoice()->getInvoiceById($invoiceId);
        if (!$invoice)
        {
            throw $this->responseException(
                $this->responseNotFound('Requested invoice not found.')
            );
        }

        return $invoice;
    }
}