<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

namespace App;

class Template
{
    protected $_templateName;

    protected $_params = array();

    public static $containerParams = array();

    public static $defaultParams = array();

    public static $required = array(
        'css' => array(),
        'js' => array()
    );

    public function __construct($templateName, array $params = array())
    {
        $this->_templateName = $templateName;
        $this->_params = array_merge(self::$defaultParams, $params);
    }

    public function render()
    {
        ob_start();

        $this->loadTemplate($this->_templateName, $this->_params);
        $contents = ob_get_contents();

        ob_end_clean();
        return $contents;
    }

    public function loadTemplate($templateName, array $params = array())
    {
        $this->_load(\App::getRegistry()->get('rootDir') . '/.templates/' . $templateName . '.php', array_merge($this->_params, $params));
    }

    public function loadCss($stylesheet)
    {
        self::$required['css'][] = $stylesheet;
        self::$required['css'] = array_unique(self::$required['css']);
    }

    public function loadJs($javascript)
    {
        self::$required['js'][] = $javascript;
        self::$required['js'] = array_unique(self::$required['js']);
    }

    public function buildLink($type, $data = null, $extraParams = array())
    {
        __(\App\Router::buildLink($type, $data, $extraParams));
    }

    public function jsEscape($str, $context = 'double')
    {
        $quote = ($context == 'double' ? '"' : "'");

        $str = str_replace(
            array('\\',   $quote,        "\r",  "\n",  '</'),
            array('\\\\', '\\' . $quote, "\\r", "\\n", '<\\/'),
            $str
        );

        return preg_replace('/-(?=-)/', '-\\', $str);
    }

    protected function _load($__file, array $__params)
    {
        $__reporting = error_reporting();
        if ($__reporting & E_NOTICE)
        {
            error_reporting($__reporting ^ E_NOTICE);
        }

        extract($__params);

        /** @noinspection PhpUnusedLocalVariableInspection */
        $containerParams = &self::$containerParams;

        if (file_exists($__file))
        {
            /** @noinspection PhpIncludeInspection */
            include $__file;
        }

        error_reporting($__reporting);
    }

    public function setParam($name, $value)
    {
        $this->_params[$name] = $value;
        return $this;
    }

    public function getParam($name)
    {
        if (isset($this->_params[$name]))
        {
            return $this->_params[$name];
        }

        return null;
    }

    public function __set($name, $value)
    {
        $this->setParam($name, $value);
    }

    public function __get($name)
    {
        return $this->getParam($name);
    }

    public static function getStaticUrl($file)
    {
        $fileName = \App::getRegistry()->get('rootDir') . '/static/' . $file;

        if (file_exists($fileName))
        {
            return self::getStaticBasePath() . $file . '?_v=' . hash('crc32', filemtime($fileName));
        }

        return false;
    }

    public static function getStaticBasePath()
    {
        return (\App::$secure ? 'https' : 'http') . '://' . \App::$host . '/static/';
    }
}