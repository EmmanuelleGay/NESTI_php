<?php

class UsersController extends BaseEntityController
{
    protected static $entityClass = "Users";
    protected static $loggedInUser;

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
    }

    public static function login()
    {
        $templateVars = [];
        $template = 'login';
        if (isset($_POST['Users'])) {

            $candidate = UsersDao::findOneBy('login', $_POST['Users']['login'], BaseDao::FLAGS['active']);

            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {

                self::setLoggedInUser($candidate, $_POST['Users']['password']);
                header('Location: ' . SiteUtil::url() . 'recipe/list');

                exit();
            } else {
                $templateVars = ['message' => 'errorLogin'];
            }
        }
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);
    }

    public static function logout()
    {
        self::setLoggedInUser(null);
        //  header('Location:'.SiteUtil::url().'users/login');
        $templateVars = ['message' => 'disconnect'];
        self::render(['action' => 'login', 'base' => 'users/baseLogin'], $templateVars);
    }


    /**
     * Get the value of user
     */
    public static function getLoggedInUser()
    {
        if (self::$loggedInUser == null &&  isset($_COOKIE['user'])) {
            $candidate = UsersDao::findOneBy('login', $_COOKIE['user']['login'], 'a');
            if ($candidate != null && $candidate->isPassword($_COOKIE['user']['password'])) {
                self::$loggedInUser = $candidate;
            };
        }
        return self::$loggedInUser;
    }

    public static function setLoggedInUser($user, $plaintextPassword = null)
    {
        if ($user != null) {
            self::$loggedInUser = $user;
            setcookie("user[login]", $user->getLogin(), 2147483647, '/');
            setcookie("user[password]", $plaintextPassword, 2147483647, '/');
        }
    }

    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);

        $vars = array_merge($vars, [
            'controllerSlug' =>  "users",
            'searchField' =>  "name"
        ]);
    }


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

    public static function confirmDelete()
    {
        static::getEntity()->setFlag('b');
        static::getDao()::saveOrUpdate(static::getEntity());

        header('Location: ' . SiteUtil::url() . 'users/list');
    }

    public static function order()
    {
        $templateName = 'order';
        static::render($templateName);
    }

    public static function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        if (isset($_POST['Users'])) {
            $isvalid = true;


            //check if city is valid and exist, create it if not
            if (!FormValidator::letters($_POST["Users"]["city"])) {
                $isvalid = false;
            }
            if ($isvalid == true) {
                $city = CityDao::findOneBy('name', $_POST["Users"]["city"]);
                if ($city == null) {
                    $city = new City();
                    $city->setName($_POST['Users']['city']);
                    CityDao::save($city);
                }
            }

            if ($isvalid) {

                $isvalid = true;

                if (
                    !FormValidator::letters($_POST["Users"]["lastName"]) ||
                    !FormValidator::letters($_POST["Users"]["firstName"]) ||
                    !FormValidator::letters($_POST["Users"]["login"]) ||
                    !FormValidator::email($_POST["Users"]["email"]) ||
                    !FormValidator::letters($_POST["Users"]["address1"]) ||
                    !FormValidator::letters($_POST["Users"]["address2"]) ||
                    !FormValidator::numbers($_POST["Users"]["zipCode"])

                ) {
                    $isvalid = false;
                }
                if ($isvalid) {

                    $entity = static::getEntity();
                    $entity->setLastName($_POST["Users"]["lastName"]);
                    $entity->setFirstName($_POST["Users"]["firstName"]);
                    $entity->setLogin($_POST["Users"]["login"]);
                    $entity->setEmail($_POST["Users"]["email"]);
                    $entity->setAddress1($_POST["Users"]["address1"]);
                    $entity->setAddress2($_POST["Users"]["address2"]);
                    $entity->setZipCode($_POST["Users"]["zipCode"]);
                    $entity->setIdCity($city->getId());

                    self::getDao()::saveOrUpdate($entity);

                    header('Location:' . SiteUtil::url() . 'users/edit/' . $entity->getId() . "/success");
                    exit();
                }
            }
        }
        // template remains "edit" if no POST user parameters, or if user parameters in POST are invalid
        self::render($templateName, $templateVars);
    }
}
