<?php

class StatisticsController extends BaseController{

    protected static $entityClass = "Statistics";

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::dashboard(); // else call default one
    }

    
    public static function dashboard()
    {
        self::render("statistics/dashboard", [
            
        ]);
    }
}


?>