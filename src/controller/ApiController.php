<?php

class ApiController extends BaseEntityController
{

    protected static $entityClass = "Api";

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
    }


    public static function test()
    {
        $recettes = ["crepes", "gateau au chocolat"];

        header('Content-Type: application/json');
        echo json_encode($recettes);

        die();
    }
    
}
