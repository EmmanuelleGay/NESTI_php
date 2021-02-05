<?php

class ArticleController extends BaseController{

    protected static $entityClass = "Article";

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
    }

}


?>