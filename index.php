<?php

/**
 * This application was built for the project for the course CSE370 by the group Onegai Sensei.
 *
 * @author A M Saif Mahmud, Tanjida Sultana, Talha Ahmed, Abdul Mueez
 * @license <unlicensed> You are not allowed to edit/redistribute the source code under any circumstances and/or in any form.
 */

$fileDir = dirname(__FILE__);
require $fileDir . '/library/App.php';

$app = new App($fileDir . '/library');
$app->getRegistry()->set('rootDir', $fileDir);
$app->start();