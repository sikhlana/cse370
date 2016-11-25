<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App;

class View
{
    protected $_request;

    protected $_response;

    protected $_requireContainer = true;

    public function __construct(\Zend_Controller_Request_Http $request, \Zend_Controller_Response_Http $response)
    {
        $this->_request = $request;
        $this->_response = $response;

        $this->setContentType('text/html; charset=UTF-8');
    }

    public function setContentType($contentType)
    {
        $this->_response->setHeader('Content-Type', $contentType, true);
    }

    public function renderError($error)
    {
        if (!is_array($error))
        {
            $error = array($error);
        }

        $params = array(
            'errorMessage' => $error,
            'errorCode' => $this->_response->getHttpResponseCode()
        );

        return $this->renderView('error', $params, $params);
    }

    public function renderView($templateName, array $params = array(), array $jsonParams = array())
    {
        $template = new Template($templateName, $params);

        if ($this->isXmlHttpRequest())
        {
            $jsonParams['templateHtml'] = $template->render();
            return $this->renderAjax($jsonParams);
        }

        return $template->render();
    }

    public function renderRedirect($redirectType, $redirectTarget, $redirectMessage = null)
    {
        if ($this->isXmlHttpRequest())
        {
            return $this->renderAjax(array(
                '_redirectStatus' => 'ok',
                '_redirectTarget' => $redirectTarget,
                '_redirectMessage' => $redirectMessage ?: 'Changes saved successfully'
            ));
        }

        $this->requireContainer(false);
        $redirectTarget = Router::convertUriToAbsoluteUri($redirectTarget);

        switch ($redirectType)
        {
            case ControllerResponse\Redirect::RESOURCE_CANONICAL_PERMANENT:
                $this->_response->setRedirect($redirectTarget, 301);
                break;

            case ControllerResponse\Redirect::SUCCESS:
                $this->_response->setRedirect($redirectTarget, 303);
                break;

            case ControllerResponse\Redirect::RESOURCE_CANONICAL:
                $this->_response->setRedirect($redirectTarget, 307);
                break;
        }

        return null;
    }

    public function renderContainer($contents, array $containerParams = array())
    {
        $containerParams += Template::$containerParams;
        $containerParams['contents'] = $contents;

        return $this->renderView('page_container', $containerParams);
    }

    public function renderAjax(array $json)
    {
        $this->requireContainer(false);
        $this->setContentType('application/json; charset=UTF-8');

        return json_encode($json, JSON_PRETTY_PRINT);
    }

    public function requireContainer($requires = null)
    {
        if ($requires !== null)
        {
            $this->_requireContainer = $requires;
        }

        return $this->_requireContainer;
    }

    public function isXmlHttpRequest()
    {
        return $this->_request->isXmlHttpRequest();
    }
}