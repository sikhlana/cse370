<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App\Route;

use App\Router;

abstract class Backbone implements MatchInterface, BuildInterface
{
    protected $_routeClasses;

    abstract protected function _getRouteClasses();

    protected function _preMatch(&$routePath, \Zend_Controller_Request_Http $request, Router $router) { }

    protected function _preBuildLink($originalPrefix, &$outputPrefix, &$action, $extension, &$data, array &$extraParams) { }

    /**
     * @return array
     */
    public function getRouteClasses()
    {
        if ($this->_routeClasses === null)
        {
            $this->_routeClasses = $this->_getRouteClasses();
        }

        return $this->_routeClasses;
    }

    public function match($routePath, \Zend_Controller_Request_Http $request, Router $router)
    {
        $this->_preMatch($routePath, $request, $router);
        $routeClass = $this->fetchClass($routePath);
        if (!$routeClass)
        {
            return false;
        }

        if (!is_string($routeClass))
        {
            return false;
        }

        if (substr($routeClass, 0, 11) === 'controller:')
        {
            @list ($controller, $action) = preg_split('/::|->|\./', substr($routeClass, 11), 2, PREG_SPLIT_NO_EMPTY);

            if ($action)
            {
                $request->setParam('_routePath', $routePath);
                $routePath = $action;
            }

            return array('controller' => $controller, 'action' => $routePath);
        }

        $route = $this->_getRouteObject($routeClass);
        if (!$route)
        {
            return false;
        }

        // You should follow XenForo's interface...
        if ($route instanceof MatchInterface)
        {
            return $route->match($routePath, $request, $router);
        }

        return false;
    }

    public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        $this->_preBuildLink($originalPrefix, $outputPrefix, $action, $extension, $data, $extraParams);
        $return = $this->_buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, $extraParams);

        if ($return === false)
        {
            $return = Router::buildBasicLink($outputPrefix, $action, $extension);
        }

        return $return;
    }

    private function _buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
    {
        $routeClass = $this->fetchClass($action, $outputPrefix);
        if (!$routeClass)
        {
            return false;
        }

        if (!is_string($routeClass))
        {
            return false;
        }

        if (substr($routeClass, 0, 11) === 'controller:')
        {
            return false;
        }

        $route = $this->_getRouteObject($routeClass);
        if (!$route)
        {
            return false;
        }

        // You should follow XenForo's interface...
        if ($route instanceof BuildInterface)
        {
            $return = $route->buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, $extraParams);

            if (is_string($return))
            {
                $return = str_replace('//', '/', $return);
            }

            return $return;
        }

        return false;
    }

    /**
     * @param $routePath
     * @param string $outputPrefix
     * @param array $classes
     * @return string|callable|false
     */
    public function fetchClass(&$routePath, &$outputPrefix = '', array $classes = null)
    {
        $pieces = explode('/', $routePath, 2);
        $prefix = $pieces[0] == '' ? 'index' : $pieces[0];

        if ($classes === null)
        {
            $classes = $this->getRouteClasses();
        }
        elseif (empty($classes) || !is_array($classes))
        {
            return false;
        }

        if (array_key_exists($prefix, $classes))
        {
            $outputPrefix .= ($outputPrefix ? '/' : '') . $prefix;
            $routePath = isset($pieces[1]) ? $pieces[1] : '';

            if (is_string($classes[$prefix]) || is_callable($classes[$prefix]))
            {
                return $classes[$prefix];
            }
            elseif (($prefix != 'index') && is_array($classes[$prefix]))
            {
                return $this->fetchClass($routePath, $outputPrefix, $classes[$prefix]);
            }
        }
        elseif (isset($classes['default']) && (is_string($classes['default']) || is_callable($classes['default'])))
        {
            return $classes['default'];
        }

        return false;
    }

    public function resolveActionWithStringParam($routePath, \Zend_Controller_Request_Http $request, $paramName)
    {
        $pieces = explode('/', $routePath, 2);

        if (isset($pieces[1]))
        {
            $request->setParam($paramName, $pieces[0]);
            return $pieces[1];
        }

        return $routePath;
    }

    /**
     * @param $routeClass
     * @return MatchInterface|BuildInterface|false
     */
    final protected function _getRouteObject($routeClass)
    {
        try
        {
            return new $routeClass();
        }
        catch (\Exception $e)
        {
            return false;
        }
    }
}