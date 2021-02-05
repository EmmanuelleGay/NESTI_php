<?php

//require_once PATH_ENTITY . 'Recipe.php';
//require_once PATH_TOOLS . 'FormatUtil.php';
//require_once PATH_MODEL . 'dao/RecipeDao.php';
//require_once PATH_MODEL . 'entity/BaseEntity.php';

//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');
//SiteUtil::require('model/entity/BaseEntity.php');



class BaseController
{

    protected static $entity;
    protected static $entityClass;
    protected static $dao;




    public static function callActionMethod($action)
    {
        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::error(); // else call default one
    }

    public static function processAction($forceAction = null)
    {
        FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
        FormatUtil::sanitize($_GET);
        //  @[$location, $action, $id] =SiteUtil::getUrlParameters();


        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        $location = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_STRING);


        if ($forceAction != null) {
            $action = $forceAction;
        }

        get_called_class()::initializeEntity($id);

        self::$dao = self::getEntityClass()::getDaoClass();

        get_called_class()::callActionMethod($action);
    }


    /**
     * render
     * renders a template
     * @param  mixed $templateName template name , or null to redirect to default action
     * @return void
     */
    protected static function render($templates, $vars = [])
    {
        if ($templates == null) {
            //si le templet eest nul(ex si on delete un article => aon applele le tmplate par dafault (ici la liste))
            self::error();
        } else {
            if (!is_array($templates)) {
                 $templates =['action'=>$templates,'base'=>'common/base'];
            }
            if (strpos($templates['action'], '/') === false) {

                $templates['action'] = strtolower(self::getEntityClass()) . "/".$templates['action'];
            }
            // Add shared parameters to the existing ones
            $vars = array_merge($vars, [
                'baseUrl' => SiteUtil::url(), // absolute url of public folder
                'entity' =>  self::getEntity(),         // current user
                'controller' => self::class,         // current user
                'templatePath' => SiteUtil::toAbsolute() . PATH_TEMPLATE . $templates['action'].".php",
                'loggedInUser' => UserController::getLoggedInUser()
            ]);

            //repars a la racine du porjet
            include_once SiteUtil::toAbsolute('view/'.$templates['base'].'.php');
        }
    }

    /**
     * initializeEntity
     * Sets user class parameter to a user from data source if specified in url, otherwise a new user
     * @return void
     */
    protected static function initializeEntity($id)
    {

        if (!empty($id)) { // If a user ID is specified in the URL

            self::setEntity(self::getDao()::findById($id)); // find corresponding user in data source
        }

        if (!self::getEntity()) { // If no ID specified, or wrong ID specified

            $class =  self::getEntityClass();

            self::setEntity(new $class);
        }
    }

    public static function getEntityClass()
    {

        return get_called_class()::$entityClass;
    }

    /**
     * edit
     * edit an existing recipe, or a newly-created one
     * @return void
     */
    public static function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            self::getEntity()->setParametersFromArray($_POST[self::getEntityClass()]);
            if (self::getEntity()->isValid()) {
                self::getDao()::saveOrUpdate(self::getEntity());
                $templateName = null; // null template will redirect to default action
            } else {
                $templateVars["errors"] = self::getEntity()->getErrors();
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }

    /**
     * delete
     * shows a delete confirmation form, which if submitted deletes user
     * @return void
     */
    public static function delete()
    {
        $templateName = 'delete';

        if (!empty($_POST)) { // if we arrived here by way of the submit button in the delete view
            self::getDao()::delete(self::getEntity());
            $templateName = null;
        }

        self::render($templateName);
    }

    public static function list()
    {
        self::render("list", [
            'entities' => self::getDao()::findAll()
        ]);
    }


    //ca va chercher dans le dossier error et abvec un / si c'est autre part que dan sle dossier de l'entité en cours
    protected static function error()
    {
        self::render('error/error404');
    }

    /**
     * Get the value of entity
     */
    public static function getEntity()
    {
        return get_called_class()::$entity;
    }

    /**
     * Get the value of entity
     */
    public static function setEntity($entity)
    {

        get_called_class()::$entity = $entity;
    }

    public static function getDao()
    {
        return get_called_class()::$dao;
    }
}
