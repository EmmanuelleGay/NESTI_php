<?php


class RecipeController extends BaseEntityController
{

    protected static $entityClass = "Recipe";

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
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
        $templateVars['ingredients']= static::getEntity()->getIngredients();
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


}
