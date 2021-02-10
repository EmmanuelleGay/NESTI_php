<?php

use Symfony\Component\Form\Util\FormUtil;

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
        $templateVars['ingredients'] = static::getEntity()->getIngredients();
        //    $templateVars['unit'] = static::getEntity()->getUnit();

        if (isset($_POST['Recipe'])) { // if we arrived here by way of the submit button in the edit view

            EntityUtil::setFromArray(self::getEntity(), $_POST[self::getEntityClass()]);

            //check fields' validity
            $isvalid = true;

            if (
                !FormValidator::letters($_POST["Recipe"]["name"]) ||
                !FormValidator::numbers($_POST["Recipe"]["difficulty"]) ||
                !FormValidator::numbers($_POST["Recipe"]["portions"]) ||
                !FormValidator::numbers($_POST["Recipe"]["preparationTime"])
            ) {
                $isvalid = false;
            }
            //create recipe
            if ($isvalid) {

                $entity = static::getEntity();

                $entity->setIdChef(UserController::getLoggedInUser()->getId());

                self::getDao()::saveOrUpdate($entity);
                //        $templateVars['message']="success";
                header('Location:' . SiteUtil::url() . 'recipe/edit/' . $entity->getId() . "/success");
                exit();
            }
        }

        //create ingredient's recipe
        if (isset($_POST['ingredient'])) {


            $isvalid = true;

            if (
                !FormValidator::letters($_POST["ingredient"]["name"]) ||
                !FormValidator::numbers($_POST["ingredient"]["quantity"]) ||
                !FormValidator::letters($_POST["ingredient"]["unit"])
            ) {
                $isvalid = false;
            }

            if ($isvalid) {

                //chek if name product already exist
                $product = ProductDao::findOneBy('name', $_POST['ingredient']['name']);
                if ($product == null) {
                    $product = new Product();
                    
                    $product->setName($_POST['ingredient']['name']);

                    ProductDao::saveOrUpdate($product);
                    $product->makeIngredient();
                }

                $ingredient = $product->getIngredient();
              
                $options = ['idIngredient' => 1, 'idRecipe' => static::$entity->getIdRecipe()];
                $ir = IngredientRecipeDao::findAll($options);
                if (empty($ir)) {
                    $ingredientRecipe = new IngredientRecipe();
                    $ingredientRecipe->setIdIngredient(1);
                    $ingredientRecipe->setQuantity($_POST['ingredient']['quantity']);
                    //         $ingredientRecipe->setUnit()->setName()( $_POST['ingredient']['unit']);
                } else {
                    $ingredientRecipe = $ir[0];
                    //déterminer ce qu'il reste a faire

                    //faire un save or update

                   IngredientRecipeDao::saveOrUpdate($ingredientRecipe);
                }
            }
        }
        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }


    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);

        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'controllerSlug' =>  "recipe",
            'searchField' =>  "name"
        ]);
    }
}
