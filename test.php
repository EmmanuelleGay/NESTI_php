<?php
/*

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include(__DIR__ . '/src/tools/SiteUtil.php');
SiteUtil::autoloadRegister();
//include('')
//SiteUtil::require('model/dao/UsersDao.php');

$myUser = UsersDao::findOneBy('login','jean');
$myUser->setPasswordHashFromPlaintext('123');

FormatUtil::dump($myUser);
UsersDao::saveOrUpdate($myUser);
echo 'mon test user'

?>*/