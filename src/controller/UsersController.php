<?php

class UsersController extends BaseEntityController
{
    protected static $entityClass = "Users";
    protected static $loggedInUser;
    
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
     * login : connect the user
     *
     * @return void
     */
    public static function login()
    {
        $templateVars = [];
        $template = 'login';
        if (isset($_POST['Users'])) {

            $candidate = UsersDao::findOneBy('login', $_POST['Users']['login'], BaseDao::FLAGS['active']);
  
            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {

                self::setLoggedInUser($candidate, $_POST['Users']['password']);
                $log = new ConnectionLog();
                $log->setIdUsers($candidate->getId());
                ConnectionLogDao::save($log);

                header('Location: ' . SiteUtil::url() . 'recipe/list');

                exit();
            } else {
                $templateVars = ['message' => 'errorLogin'];
            }
        }
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);
    }
    
    /**
     * logout
     *
     * @return void
     */
    public static function logout()
    {
        self::setLoggedInUser(null);
        setcookie("user[login]", null, 2147483647, '/');
        setcookie("user[password]", null, 2147483647, '/');
        $templateVars = ['message' => 'disconnect'];
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);
    }


    /**
     * getLoggedInUser
     *
     *  Get the value of user
     * @param  mixed $refresh
     */
    public static function getLoggedInUser($refresh = false)
    {
        if ($refresh ||  self::$loggedInUser == null && isset($_COOKIE['user']['login']) && isset($_COOKIE['user']['password']) ) {
            $candidate = UsersDao::findOneBy('login', $_COOKIE['user']['login'], 'a');
            if ($candidate != null && $candidate->isPassword($_COOKIE['user']['password'])) {
                self::$loggedInUser = $candidate;
            };
        }
        return self::$loggedInUser;
    }

     
    /**
     * setLoggedInUser
     *
     * @param  mixed $user
     * @param  mixed $plaintextPassword
     * @return void
     */
    public static function setLoggedInUser($user, $plaintextPassword = null)
    {
        if ($user != null) {
            self::$loggedInUser = $user;
            setcookie("user[login]", $user->getLogin(), 2147483647, '/');
            setcookie("user[password]", $plaintextPassword, 2147483647, '/');
        }
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

        $vars = array_merge($vars, [
            'controllerSlug' =>  "users",
            'searchField' =>  "name"
        ]);
    }

    
    /**
     * list all the users
     *
     * @return void
     */
    public static function list()
    {
        if (isset($_POST["search"])) {
            foreach ($_POST["search"] as $key => $value) {
                $queryOptions["$key LIKE"] = "%$value%";
            }
        };
        static::render("list", [
            'entities' => static::getDao()::findAll()
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

        header('Location: ' . SiteUtil::url() . 'users/list');
    }

    
    /**
     * edit
     *
     * @return void
     */
    public static function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

       

        if (isset($_POST['Users'])) {
            $isvalid = true;

            $entity = static::getEntity();

            //check if city is valid and exist, create it if not
      
            if ($isvalid == true) {
                $city = CityDao::findOneBy('name', $_POST["Users"]["city"]);
                if ($city == null) {
                    $city = new City();
                    $city->setName($_POST['Users']['city']);
                    CityDao::save($city);
                }
            }

            
            if($isvalid && $entity->getId()== ""){
                $user = UsersDao::findOneBy('login', $_POST["Users"]['login']);
                if ($user){
                    $isvalid = false;
                    $templateVars = ['message' => 'errorFormLogin'];
                }
            }

            if($isvalid && $entity->getId()== ""){
                $user = UsersDao::findOneBy('email', $_POST["Users"]['email']);
                if ($user){
                    $isvalid = false;
                    $templateVars = ['message' => 'errorFormEmail'];
                }
            }

            if ($isvalid) {

                if (

                    !FormValidator::letters($_POST["Users"]["lastName"]) ||
                    !FormValidator::letters($_POST["Users"]["firstName"]) ||
                    !FormValidator::email($_POST["Users"]["email"]) ||
                    !FormValidator::numbers($_POST["Users"]["zipCode"]) 

                ) {
                    $isvalid = false;
                    $templateVars = ['message' => 'errorForm'];
                }


                if(!FormValidator::strong($_POST["Users"]["password"]) && $entity->getId()== ""){
                    $isvalid = false;
                    $templateVars = ['message' => 'strongPassword'];
                }

                //insert other field
                if ($isvalid) {

                

                    //hash password before insert for a new user
                    if ($entity->getId() == "") {
                        $entity->setPasswordHashFromPlaintext($_POST["Users"]["password"]);
                    }

                    $entity->setLastName($_POST["Users"]["lastName"]);
                    $entity->setFirstName($_POST["Users"]["firstName"]);
                    $entity->setLogin($_POST["Users"]["login"]);
                    $entity->setEmail($_POST["Users"]["email"]);
                    $entity->setAddress1($_POST["Users"]["address1"]);
                    $entity->setAddress2($_POST["Users"]["address2"]);
                    $entity->setZipCode($_POST["Users"]["zipCode"]);
                    $entity->setFlag($_POST["Users"]["flag"]);

                    if (isset($city)) {
                        $entity->setIdCity($city->getId());
                    }

                    self::getDao()::saveOrUpdate($entity);

                    if (isset($_POST["Users"]["chef"])) {
                        $entity->makeChef();
                    }

                    if (isset($_POST["Users"]["administrator"])) {
                        $entity->makeAdministrator();
                    }

                    if (isset($_POST["Users"]["moderator"])) {
                        $entity->makeModerator();
                    }


                    header('Location:' . SiteUtil::url() . 'users/edit/' . $entity->getId() . "/success");

                    exit();
                }
            }
        }
        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }
    
    
    /**
     * blockComment
     *
     * @return void
     */
    public static function blockComment()
    {
        $entity = static::getEntity();
        $idRecipe =  SiteUtil::getUrlParameters()[2] ?? "";
        FormatUtil::dump("test".   $idRecipe );
        header('Location: ' . SiteUtil::url() . 'users/edit/' .$entity->getId());
    }
    
    /**
     * moderateComment
     *
     * @return void
     */
    public static function moderateComment(){

        $comment = CommentDao::findOne(["idRecipe"=>$_POST["idrecipe"],"idUsers"=>$_POST["iduser"] ]);
        $flag = "error";
        if ($comment!=null){
            $flag = $_POST["blocks"]=="true"?"b":"a";
            $comment->setFlag($flag);
            CommentDao::saveOrUpdate($comment);
        }
        echo json_encode($flag);
    }
}
