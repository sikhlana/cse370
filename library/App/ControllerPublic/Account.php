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
use App\Router;
use App\Input;

class Account extends ControllerPublic
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

    public function actionIndex()
    {
        $this->_setMinorSection('dashboard');
        $user = $this->_user;

        $wishlist = $this->models()->wishlist()->getWishlistForUserDisplay($user['user_id']);
        $wishlist = $this->models()->movie()->prepareMovies($wishlist);
        $orders = $this->models()->order()->getOrdersWithInvoiceForUser($user['user_id']);

        $viewParams = array(
            'user' => $user,
            'wishlist' => $wishlist,
            'orders' => $orders
        );

        return $this->responseView('account_dashboard', $viewParams);
    }

    public function actionBilling()
    {
        $this->_setMinorSection('billing');
        $user = $this->_user;

        $viewParams = array(
            'user' => $user,
            'countryOptions' => $this->models()->user()->getCountryOptions($user['billing_country'])
        );

        return $this->responseView('account_billing', $viewParams);
    }

    public function actionBillingSave()
    {
        $this->_assertPostOnly();

        $data = $this->_input->filter(array(
            'first_name' => Input::STRING,
            'last_name' => Input::STRING,
            'billing_street_1' => Input::STRING,
            'billing_street_2' => Input::STRING,
            'billing_zip' => Input::STRING,
            'billing_city' => Input::STRING,
            'billing_country' => Input::STRING
        ));

        $user = $this->_user;
        $changes = array();

        foreach ($data as $k => $v)
        {
            if ($user[$k] != $v)
            {
                $changes[$k] = $v;
            }
        }

        if (!empty($changes))
        {
            if ($this->models()->user()->update($user['user_id'], $changes))
            {
                \App::getSession()->set(
                    'user', $this->models()->user()->getUserById($user['user_id'])
                );
            }
        }

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('account/billing')
        );
    }

    public function actionCheckout()
    {
        $order = \App::getSession()->get('order');

        if (!$order)
        {
            return $this->responseError('Please create an order first.');
        }

        $tickets = $this->models()->ticket()->getAllTicketsForOrderWithMovieAndHall($order['order_id']);
        if (empty($tickets))
        {
            return $this->responseError('Your order is empty.');
        }

        $totalPrice = 0;

        foreach ($tickets as &$ticket)
        {
            $totalPrice += $ticket['ticket_price'];
            $ticket = $this->models()->showtime()->prepareShowtime($ticket);
        }

        $viewParams = array(
            'order' => $order,
            'tickets' => $tickets,

            'totalPrice' => $totalPrice
        );

        return $this->responseView('account_checkout', $viewParams);
    }

    public function actionCheckoutCancel()
    {
        $order = \App::getSession()->get('order');

        if (!$order)
        {
            return $this->responseError('Please create an order first.');
        }

        $tickets = $this->models()->ticket()->getAllTicketsForOrderWithMovieAndHall($order['order_id']);
        if (empty($tickets))
        {
            return $this->responseError('Your order is empty.');
        }

        $this->models()->order()->deleteOrder($order['order_id']);
        \App::getSession()->remove('order');

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('account'),
            'Your order has been successfully cancelled.'
        );
    }

    public function actionCheckoutPay()
    {
        $order = \App::getSession()->get('order');

        if (!$order)
        {
            return $this->responseError('Please create an order first.');
        }

        $tickets = $this->models()->ticket()->getAllTicketsForOrderWithMovieAndHall($order['order_id']);
        if (empty($tickets))
        {
            return $this->responseError('Your order is empty.');
        }

        $totalPrice = 0;

        foreach ($tickets as &$ticket)
        {
            $totalPrice += $ticket['ticket_price'];
        }

        $invoice = $this->models()->invoice()->createInvoice($order, $totalPrice, 0);
        if (!$invoice)
        {
            return $this->responseError('Unable to create invoice for the order.');
        }

        \App::getSession()->remove('order');
        $this->models()->invoice()->markInvoiceAsPaid($invoice['invoice_id']);

        return $this->responseRedirect(
            Redirect::SUCCESS,
            Router::buildLink('account/invoices/print/tickets', $invoice),
            'Your order has been successfully processed.'
        );
    }

    public function actionLogout()
    {
        \App::getSession()->kill();

        return $this->responseRedirect(
            Redirect::SUCCESS,
            $this->getDynamicRedirect(),
            'You have been successfully logged out.'
        );
    }
}