<?php
require_once PATH_ENTITY.'Recipe.php';
require_once PATH_TOOLS.'FormatUtil.php';
require_once PATH_MODEL.'dao/RecipeDao.php';
require_once PATH_MODEL.'entity/BaseEntity.php';

class BaseControllerOLD {

    protected  $entity;

    public function __construct(){
           

        FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
        FormatUtil::sanitize($_GET);

        $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET,'action',FILTER_SANITIZE_STRING);
        $location = filter_input(INPUT_GET,'loc',FILTER_SANITIZE_STRING);

    //     $id = $_GET['id'];
    //    $action = $_GET['action'];

        // action is first slug in url, id second
        //   @[$action, $id] = SiteUtil::getUrlParameters();

        $this->initializeEntity($id);
        
       if($location=="user"){
           new UserController();
       }
    }
    
    protected function processAction($action){
        method_exists($this, $action)?
        $this->$action(): // if action in URL exists, call it
        $this->default(); // else call default one
    }
        /**
         * initializeEntity
         * Sets user class parameter to a user from data source if specified in url, otherwise a new user
         * @return void
         */
        private function initializeEntity($id){
            $entityClass = $this->entity->getClass();
            if (!empty($id)) { // If a user ID is specified in the URL
               
                $this->entity =  $entityClass::getDaoClass()::findById($id); // find corresponding user in data source
            }
          
            if (!$this->entity){ // If no ID specified, or wrong ID specified
                $this->entity = new $entityClass;
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
                    'baseUrl' => SiteUtil::url().'public', // absolute url of public folder
                    'recipe' => $this->recipe,         // current user
                    'templatePath' => PATH_TEMPLATE."recipe/$templateName.php"
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
            $this->render("listRecipe", [
                'recipes' => RecipeDao::findAll()
            ]);
        }
    
    
    }
?>