<?php
/*
require_once PATH_MODEL . 'dao/BaseDao.php';
require_once PATH_CTRL . 'BaseController.php';
require_once PATH_MODEL . 'entity/BaseEntity.php';
require_once PATH_MODEL . 'dao/UsersDao.php';
*/

SiteUtil::require('controller/BaseController.php');
SiteUtil::require('model/entity/Users.php');
SiteUtil::require('model/entity/BaseEntity.php');
SiteUtil::require('model/dao/UsersDao.php');

class UserController extends BaseEntityController
{
    protected static $entityClass = "Users";
    protected static $loggedInUser;

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
    }

    public static function login()
    {
        $template = 'login';
        if (isset($_POST['Users'])) {

            $candidate = UsersDao::findOneBy('login', $_POST['Users']['login'],BaseDao::FLAGS['active']);

            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {
             
                self::setLoggedInUser($candidate,$_POST['Users']['password']);
                header('Location: '.SiteUtil::url().'recipe/list');

                exit();
            }
            else {
                $templateVars = ['message'=>'errorLogin'];
            }
        }
        self::render(['action'=>'login','base'=>'users/baseLogin'],$templateVars);
    }


public static function logout() {
    self::setLoggedInUser(null);
 //  header('Location:'.SiteUtil::url().'users/login');
    $templateVars = ['message'=>'disconnect'];
    self::render(['action'=>'login','base'=>'users/baseLogin'],$templateVars);
}


    /**
     * Get the value of user
     */
    public static function getLoggedInUser()
    { 
        if (self::$loggedInUser==null &&  isset($_COOKIE['user']))
        {
        $candidate = UsersDao::findOneBy('login', $_COOKIE['user']['login'],'a');
        if($candidate != null && $candidate->isPassword($_COOKIE['user']['password'])){
            self::$loggedInUser =$candidate;
         };
        }
        return self::$loggedInUser;
    }

    public static function setLoggedInUser($user,$plaintextPassword=null){
        if($user!=null){
            self::$loggedInUser =$user;
            setcookie("user[login]", $user->getLogin(), 2147483647, '/');
            setcookie("user[password]",$plaintextPassword, 2147483647, '/');
        }
    }
}
