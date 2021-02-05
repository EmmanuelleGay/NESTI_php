<?php

require_once PATH_MODEL.'dao/BaseDao.php';
require_once PATH_CTRL.'BaseController.php';

require_once PATH_MODEL.'entity/BaseEntity.php';
require_once PATH_ENTITY.'Recipe.php';

require_once PATH_MODEL.'dao/RecipeDao.php';




class RecipeControllerOLD extends BaseController{

        protected $recipe;
      
        /**
         * __construct
         * constructor sanitizes request, initializes a user, and calls an action 
         * @return void
         */
        public function __construct(){
           

            FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
            FormatUtil::sanitize($_GET);
    
            $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
            $action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);

       //     $id = $_GET['id'];
        //    $action = $_GET['action'];

            // action is first slug in url, id second
         //   @[$action, $id] = SiteUtil::getUrlParameters();

            $this->initializeRecipe($id);
            
            method_exists($this, $action)?
                $this->$action(): // if action in URL exists, call it
                $this->default(); // else call default one
        }
        
        /**
         * initializeEntity
         * Sets user class parameter to a user from data source if specified in url, otherwise a new user
         * @return void
         */
        private function initializeRecipe($id){
            if (!empty($id)) { // If a user ID is specified in the URL
                $this->recipe = RecipeDao::findById($id); // find corresponding user in data source
            }
            
            if (!$this->recipe){ // If no ID specified, or wrong ID specified
                $this->recipe = new Recipe;
            }
        }
        
        /**
         * edit
         * edit an existing recipe, or a newly-created one
         * @return void
         */
        private function edit(){
            $templateName = 'edit'; 
            $templateVars = ["isSubmitted" => !empty($_POST['recipe'])];
    
            if ($templateVars["isSubmitted"]) { // if we arrived here by way of the submit button in the edit view
                $this->recipe->setParametersFromArray($_POST['recipe']);
                if ($this->recipe->isValid()) {
                    RecipeDao::saveOrUpdate($this->recipe);
                    $templateName = null; // null template will redirect to default action
                } else {
                    $templateVars["errors"] = $this->recipe->getErrors();
                }
            }
            
            // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
            $this->render($templateName, $templateVars);
        }
        
        /**
         * delete
         * shows a delete confirmation form, which if submitted deletes user
         * @return void
         */
        private function delete(){
            $templateName = 'delete'; 
    
            if (!empty($_POST)) { // if we arrived here by way of the submit button in the delete view
                RecipeDao::delete($this->recipe);
                $templateName = null; 
            }
    
            $this->render($templateName);
        }
      
        /**
         * render
         * renders a template
         * @param  mixed $templateName template name , or null to redirect to default action
         * @return void
         */
        private function render($templateName, $vars=[]){
            if ($templateName == null){
                //si le templet eest nul(ex si on delete un article => aon applele le tmplate par dafault (ici la liste))
                $this->default();
            }else{
                // Add shared parameters to the existing ones
                $vars = array_merge($vars, [
                    'baseUrl' => SiteUtil::url(), // absolute url of public folder
                    'recipe' => $this->recipe,         // current recipe
                    'templatePath' => SiteUtil::toAbsolute().PATH_TEMPLATE."recipe/$templateName.php"
                ]);

        //pour que ca fonctionne pour toutes les aciton, on passe le nom du template
                include_once PATH_TEMPLATE."common/base.php";

            }
        }
    
                
        /**
         * read
         * view user parameters
         * @return void
         */
        private function read(){
            $this->render('read');
        }
        
        /**
         * default
         * default action (called if no action specified, wrong action specified, or null template specified)
         * @return void
         */
        private function default(){
            $this->render("list", [
                'recipes' => RecipeDao::findAll()
            ]);
        }
    
    
    }
    ?>