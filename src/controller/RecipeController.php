<?php

/*
require_once PATH_MODEL.'dao/BaseDao.php';
require_once PATH_CTRL.'BaseController.php';

require_once PATH_MODEL.'entity/BaseEntity.php';
require_once PATH_ENTITY.'Recipe.php';
require_once PATH_MODEL.'dao/RecipeDao.php';*/

//SiteUtil::require('controller/BaseController.php');
//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');




class RecipeController extends BaseEntityController
{

    protected static $entityClass = "Recipe";




    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
    }

   
}
