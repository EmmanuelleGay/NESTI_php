<?php
require_once PATH_MODEL . 'dao/BaseDao.php';
require_once PATH_CTRL . 'BaseController.php';
require_once PATH_MODEL . 'entity/BaseEntity.php';
require_once PATH_ENTITY . 'Recipe.php';

require_once PATH_MODEL . 'dao/RecipeDao.php';




class RecipeController extends BaseController
{

    protected $user;

    protected function login()
    {
        $this->render('login');
    }
}
