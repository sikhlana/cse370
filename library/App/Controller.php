<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App;

abstract class Controller
{
    /**
     * @var \Zend_Controller_Request_Http
     */
    protected $_request;

    /**
     * @var \Zend_Controller_Response_Http
     */
    protected $_response;

    protected $_input;

    protected $_majorSection;

    protected $_minorSection;

    public function __construct(\Zend_Controller_Request_Http $request, \Zend_Controller_Response_Http $response)
    {
        $this->_request = $request;
        $this->_response = $response;
        $this->_input = new Input($request);
    }

    public function preDispatch($action)
    {
        $this->_preDispatch($action);
    }

    protected function _preDispatch($action) { }

    protected function _setMajorSection($section)
    {
        $this->_majorSection = $section;
    }

    protected function _setMinorSection($section)
    {
        $this->_minorSection = $section;
    }

    public function postDispatch(ControllerResponse $controllerResponse, $controllerName, $action)
    {
        $this->_postDispatch($controllerResponse, $controllerName, $action);

        Template::$defaultParams['majorSection'] = $this->_majorSection;
        Template::$defaultParams['minorSection'] = $this->_minorSection;

        $order = \App::getSession()->get('order');
        if (!empty($order['tickets']))
        {
            $controllerResponse->containerParams['hasOrder'] = true;
        }
    }

    protected function _postDispatch(ControllerResponse $controllerResponse, $controllerName, $action) { }

    public function responseAjax(array $output)
    {
        $controllerResponse = new ControllerResponse\Ajax();
        $controllerResponse->jsonParams = $output;
        return $controllerResponse;
    }

    public function responseView($templateName, array $params = array(), array $containerParams = array())
    {
        $controllerResponse = new ControllerResponse\View();
        $controllerResponse->templateName = $templateName;
        $controllerResponse->params = $params;
        $controllerResponse->containerParams = $containerParams;
        return $controllerResponse;
    }

    public function responseError($message, $errorCode = 400)
    {
        $controllerResponse = new ControllerResponse\Error();
        $controllerResponse->message = $message;
        $controllerResponse->code = $errorCode;
        return $controllerResponse;
    }

    public function responseRedirect($redirectType, $redirectTarget, $redirectMessage = null)
    {
        $controllerResponse = new ControllerResponse\Redirect();
        $controllerResponse->redirectType = $redirectType;
        $controllerResponse->redirectTarget = $redirectTarget;
        $controllerResponse->redirectMessage = $redirectMessage;
        return $controllerResponse;
    }

    public function responseNoPermission()
    {
        $user = \App::getSession()->get('user');
        if (empty($user['user_id']))
        {
            $message = 'Please login to access this page.';
        }
        else
        {
            $message = 'You do not have permission to access this page.';
        }

        return $this->responseError($message, 403);
    }

    public function responseNotFound($message = 'Requested page not found.')
    {
        return $this->responseError($message, 404);
    }

    public function responseException(ControllerResponse $controllerResponse)
    {
        $exception = new ControllerResponse\Exception();
        $exception->setControllerResponse($controllerResponse);
        return $exception;
    }

    protected $_models;

    /**
     * @return Helper\ModelList
     */
    public function models()
    {
        if (!$this->_models)
        {
            $this->_models = new Helper\ModelList();
        }

        return $this->_models;
    }

    protected function _assertPostOnly()
    {
        if (!$this->_request->isPost())
        {
            throw $this->responseException(
                $this->responseError('This action is available via POST only.', 405)
            );
        }
    }

    public function getDynamicRedirect($fallbackUrl = false, $useReferrer = true)
    {
        $redirect = $this->_input->filterSingle('redirect', Input::STRING);
        if (!$redirect && $useReferrer)
        {
            $redirect = $this->_request->getServer('HTTP_X_AJAX_REFERER');
            if (!$redirect)
            {
                $redirect = $this->_request->getServer('HTTP_REFERER');
            }
        }

        if ($redirect)
        {
            $redirect = strval($redirect);
            if (strlen($redirect) && !preg_match('/./u', $redirect))
            {
                $redirect = utf8_strip($redirect);
            }

            if (strpos($redirect, "\n") === false && strpos($redirect, "\r") === false) {
                $fullRedirect = Router::convertUriToAbsoluteUri($redirect, true);
                $redirectParts = @parse_url($fullRedirect);
                if ($redirectParts && !empty($redirectParts['host']))
                {
                    $paths = \App::getRegistry()->get('requestPaths');
                    $pageParts = @parse_url($paths['fullUri']);

                    if ($pageParts && !empty($pageParts['host']) && $pageParts['host'] == $redirectParts['host'])
                    {
                        return $fullRedirect;
                    }
                }
            }
        }

        if ($fallbackUrl === false)
        {
            $fallbackUrl = Router::buildLink('index');
        }

        return $fallbackUrl;
    }
}