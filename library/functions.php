<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

if (!function_exists('__'))
{
    function __($str)
    {
        echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('___'))
{
    function ___($str)
    {
        echo $str;
    }
}