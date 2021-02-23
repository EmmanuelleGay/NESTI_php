<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//session_start();

include(__DIR__ . '/../config/constant.php');
include(__DIR__ . '/../src/tools/SiteUtil.php');
SiteUtil::autoloadRegister();

SiteUtil::require('tools/SiteUtil.php');

$loc = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

//geturlparameter retourne un tableau qui retourne les tableaux (ex user/edit/14)
//@[$loc] =SiteUtil::getUrlParameters();


if (!isset($loc)) {
    $loc = 'recipe';
}

if (UsersController::getLoggedInUser() != null) {
    switch ($loc) {

        case 'recipe':
            RecipeController::processAction();
            break;
        case 'article':
            ArticleController::processAction();
            break;
        case 'statistics':
            StatisticsController::processAction();
            break;
        case '':
            RecipeController::processAction('list');
            break;
        default:
            UsersController::processAction('');
    }
} else {
    UsersController::processAction('login');
}
