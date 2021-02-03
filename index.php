<?php

include('config/constant.php');
require_once PATH_MODEL.'entity/BaseEntity.php';
require_once PATH_MODEL.'dao/BaseDao.php';
require_once PATH_CTRL.'BaseController.php';
require_once PATH_CTRL.'RecipeController.php';
require_once PATH_TOOLS.'SiteUtil.php';

$loc = filter_input(INPUT_GET,'loc',FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);

switch($loc) {
    case 'recipe':
        new RecipeController;
 //       include ('src/controller/controlRecipe.php');
        break;

        default;
}




?>