<?php

//require_once PATH_ENTITY . 'Recipe.php';
//require_once PATH_TOOLS . 'FormatUtil.php';
//require_once PATH_MODEL . 'dao/RecipeDao.php';
//require_once PATH_MODEL . 'entity/BaseEntity.php';

//SiteUtil::require('model/entity/Recipe.php');
//SiteUtil::require('model/entity/BaseEntity.php');
//SiteUtil::require('model/dao/RecipeDao.php');
//SiteUtil::require('model/entity/BaseEntity.php');



class BaseEntityController extends BaseController
{

    protected static $entity;
    protected static $entityClass;
    protected static $dao;

    public static function processAction($forceAction = null)
    {
        SiteUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
        SiteUtil::sanitize($_GET);
        //  @[$location, $action, $id] =SiteUtil::getUrlParameters();


        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        $location = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_STRING);


        if ($forceAction != null) {
            $action = $forceAction;
        }

        static::$dao = static::getEntityClass()::getDaoClass();
        static::initializeEntity($id);

        static::callActionMethod($action);
    }

    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);
        if (strpos($templates['action'], '/') === false) {

            $templates['action'] = strtolower(static::getEntityClass()) . "/" . $templates['action'];
        }

        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'entity' =>  static::getEntity(),
            'templatePath' => SiteUtil::toAbsolute() . PATH_TEMPLATE . $templates['action'] . ".php",
            //on peut mettre toutes les variables nécessaires dans JS
            'jsVars' => [
                'entity' => [
                    'id' =>  static::getEntity()->getId()
                ]
            ]
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

            static::setEntity(static::getDao()::findById($id)); // find corresponding user in data source
        }

        if (!static::getEntity()) { // If no ID specified, or wrong ID specified

            $class =  static::getEntityClass();

            static::setEntity(new $class);
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
        $templateVars = ["isSubmitted" => !empty($_POST[static::getEntityClass()])];

        if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
            static::getEntity()->setParametersFromArray($_POST[static::getEntityClass()]);
            if (static::getEntity()->isValid()) {
                static::getDao()::saveOrUpdate(static::getEntity());
                $templateName = null; // null template will redirect to default action
            } else {
                $templateVars["errors"] = static::getEntity()->getErrors();
            }
        }

        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        static::render($templateName, $templateVars);
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
            static::getDao()::delete(static::getEntity());
            $templateName = null;
        }

        static::render($templateName);
      
    }

    public static function list()
    {
        $queryOptions = ['flag' => 'a'];

        if (isset($_POST["search"])) {
            foreach ($_POST["search"] as $key => $value) {
                $queryOptions["$key LIKE"] = "%$value%";
            }
        };
        static::render("list", [
            'entities' => static::getDao()::findAll($queryOptions)
        ]);
    }

    /**
     * Get the value of entity
     */
    public static function getEntity()
    {
        return static::$entity;
    }

    /**
     * Get the value of entity
     */
    public static function setEntity($entity)
    {

        static::$entity = $entity;
    }

    public static function getDao()
    {
        return static::$dao;
    }
}
