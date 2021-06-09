<?php

class RecipeController extends BaseEntityController
{

    protected static $entityClass = "Recipe";


    /**
     * callActionMethod
     *
     * @param  mixed $action
     * @return void
     */
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
        //   $templateVars['ingredients'] = static::getEntity()->getIngredients();

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

                $entity->setIdChef(UsersController::getLoggedInUser()->getId());

                $entity->setDateModification(FormatUtil::currentSqlDate());

                if (isset($_FILES["Recipe"]["tmp_name"]["linkImage"]) && $_FILES["Recipe"]["error"]["linkImage"] == 0) {
                    
                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                    $filename = $_FILES["Recipe"]["name"]["linkImage"];
                    $filetype = $_FILES["Recipe"]["type"]["linkImage"];
                    $filesize = $_FILES["Recipe"]["size"]["linkImage"];


                    //Valid file's extension
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                     if (!array_key_exists($ext, $allowed)) {
                         die("Erreur : Veuillez sélectionner un format de fichier valide.");
                     }

                   //  Vérifie la taille du fichier - 5Mo maximum
                     $maxsize = 5 * 1024 * 1024;
                     if ($filesize > $maxsize) {
                         die("Erreur: La taille du fichier est supérieure à la limite autorisée.");
                     }

                    // check MIME type of the file
                    $imageFolder = SiteUtil::toAbsolute()."public/images/recipes/". $_FILES["Recipe"]["name"]["linkImage"];
                    if (in_array($filetype, $allowed)) {
                            move_uploaded_file($_FILES["Recipe"]["tmp_name"]["linkImage"],$imageFolder);
                        }

                    //if image is valid, insert into db
                    if (isset($_FILES["Recipe"]["tmp_name"])) {
                        $idImage = $entity->getIdImage();
                        if($idImage==null){
                            $image = new Image();
                        }else {
                            $image = ImageDao::findById($idImage);
                        }
                      
                        $arrayNameImage = explode(".", $_FILES["Recipe"]["name"]["linkImage"]);
                        $image->setName($arrayNameImage[0]);
                        $image->setFileExtension($arrayNameImage[1]);
                        ImageDao::saveOrUpdate($image);
                        $idImage=$image->getId();
                        $entity->setIdImage($idImage);
                    }
                }

                self::getDao()::saveOrUpdate($entity);
            
                header('Location:' . SiteUtil::url() . 'recipe/edit/' . $entity->getId() . "/success");
                exit();

            } else {
                $templateVars = ['message' => 'error'];
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

                    ProductDao::save($product);
                    $product->makeIngredient();
                }

                //check if unit alreaydy exist
                $unit = UnitDao::findOneBy('name', $_POST['ingredient']['unit']);
                if ($unit == null) {
                    $unit = new Unit();
                    $unit->setName($_POST['ingredient']['unit']);
                    UnitDao::saveOrUpdate($unit);
                }

                //    //check if ingredientRecipe exists
                $ingredient = $product->getIngredient();

                $options = ['idIngredient' => $ingredient->getId(), 'idRecipe' => static::$entity->getIdRecipe()];
                $ingredientRecipe = IngredientRecipeDao::findOne($options);

                //      //add ingredient to the recipe
                if ($ingredientRecipe == null){
                    $ingredientRecipe = new IngredientRecipe();
                    $ingredientRecipe->setIdRecipe(static::$entity->getIdRecipe());

                    $ingredientRecipe->setIdIngredient($ingredient->getId());
                  
                  
                } 
                   
                $ingredientRecipe->setQuantity($_POST['ingredient']['quantity']);
                $ingredientRecipe->setIdUnit($unit->getId());
                IngredientRecipeDao::saveOrUpdate($ingredientRecipe);

            } else {
                $templateVars = ['message' => 'error'];
            }
        }
        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }

        
    /**
     * setupTemplateVars
     *
     * @param  mixed $vars
     * @param  mixed $templates
     * @return void
     */
    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);

        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'controllerSlug' =>  "recipe",
            'searchField' =>  "name"
        ]);
    }
    
    /**
     * confirmDelete
     *
     * @return void
     */
    public static function confirmDelete()
    {
        static::getEntity()->setFlag('b');
        static::getDao()::saveOrUpdate(static::getEntity());

        header('Location: ' . SiteUtil::url() . 'recipe/list');
    }

    
    /**
     * getParagraphs
     *
     * @return void
     */
    public static function getParagraphs()
    {
        $arrayParagraph = [];
        $entity = static::getEntity();
        $paragraphs = $entity->getParagraphs(["ORDER" => "paragraphOrder ASC"]);
        foreach ($paragraphs as $paragraph) {
            $arrayParagraph[] = [
                "position" => $paragraph->getParagraphOrder(),
                "content" => $paragraph->getContent(),
                "idParagraph" => $paragraph->getId()
            ];
        }
        //on l'envoie en json pour communiquer en js
        echo json_encode($arrayParagraph);
    }
    
    /**
     * addParagraph
     *
     */
    public static function addParagraph()
    {
        $recipe = static::getEntity();
        $paragraph = new Paragraph();
        $paragraph->setRecipe($recipe)->setContent("");
        $paragraph->setParagraphOrder(count($recipe->getParagraphs()));
        ParagraphDao::saveOrUpdate($paragraph);
    }
    
    /**
     * saveParagraph
     *
     * @return void
     */
    public static function saveParagraph()
    {
        $recipe = static::getEntity();
        if (isset($_POST["idParagraph"])) {
            $paragraph = ParagraphDao::findById($_POST["idParagraph"]);
            $paragraph->setContent($_POST["content"]);
            ParagraphDao::saveOrUpdate($paragraph);
        }
    }
    
    /**
     * deleteParagraph
     *
     * @return void
     */
    public static function deleteParagraph()
    {
        $recipe = static::getEntity();
        if (isset($_POST["idParagraph"])) {
            $paragraph = ParagraphDao::findById($_POST["idParagraph"]);
            ParagraphDao::delete($paragraph);
            $paragraphs = static::getEntity()->getParagraphs(["ORDER" => "paragraphOrder ASC"]);
            static::reOrderParagraphs($paragraphs);
        }
    }
    
    /**
     * moveParagraph
     *
     * @return void
     */
    public static function moveParagraph()
    {
        $recipe = static::getEntity();
        if (isset($_POST["idParagraph"])) {
            $paragraph = ParagraphDao::findById($_POST["idParagraph"]);

            $paragraphs = static::getEntity()->getParagraphs(["ORDER" => "paragraphOrder ASC"]);
            $index = $paragraph->getParagraphOrder() - 1;
            ArrayUtil::move($paragraphs, $index, $index + $_POST["direction"]);
            static::reOrderParagraphs($paragraphs);
        }
    }
    
    /**
     * reOrderParagraphs
     *
     * @param  mixed $paragraphs
     * @return void
     */
    public static function reOrderParagraphs($paragraphs)
    {
        foreach ($paragraphs as $i => $paragraph) {
            $paragraph->setParagraphOrder($i + 1);
            ParagraphDao::saveOrUpdate($paragraph);
        }
    }
}
