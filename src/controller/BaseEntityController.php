<?php

//require_once PATH_ENTITY . 'Recipe.php';
//require_once PATH_TOOLS . 'FormatUtil.php';
//require_once PATH_MODEL . 'dao/RecipeDao.php';
//require_once PATH_MODEL . 'entity/BaseEntity.php';

//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');
//SiteUtil::require('model/entity/BaseEntity.php');



class BaseEntityController extends baseController
{

    protected static $entity;
    protected static $entityClass;
    protected static $dao;

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

    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);
        if (strpos($templates['action'], '/') === false) {

            $templates['action'] = strtolower(self::getEntityClass()) . "/".$templates['action'];
        }

        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'entity' =>  self::getEntity(),
            'templatePath' => SiteUtil::toAbsolute() . PATH_TEMPLATE . $templates['action'].".php",
        ]);
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
