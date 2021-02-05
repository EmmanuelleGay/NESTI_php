<?php

use phpDocumentor\Reflection\Location;

require_once PATH_MODEL . 'dao/BaseDao.php';
require_once PATH_CTRL . 'BaseController.php';
require_once PATH_MODEL . 'entity/BaseEntity.php';
require_once PATH_MODEL . 'dao/UsersDao.php';




class UserControllerOLD extends BaseController
{

    protected $user;

    public function __construct()
    {

        FormatUtil::sanitize($_POST); // need recursive sanitizing for multidimensional array
        FormatUtil::sanitize($_GET);

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

        if ($this->user == null) {
            $this->login();
        } else {
            method_exists($this, $action) ?
                $this->$action() : // if action in URL exists, call it
                $this->default(); // else call default one
        }
    }



    /**
     * render
     * renders a template
     * @param  mixed $templateName template name , or null to redirect to default action
     * @return void
     */
    private function render($templateName, $vars = [])
    {
        if ($templateName == null) {
            //si le template est nul(ex si on delete un article => on appelle le template par default (ici la liste))
            $this->default();
        } else {
            // Add shared parameters to the existing ones
            $vars = array_merge($vars, [
                'baseUrl' => SiteUtil::url(), // absolute url 
                'user' => $this->user,         // current user
      //          'controller'=>$this,
                'templatePath' => PATH_TEMPLATE . "user/$templateName.php"
            ]);
            //pour que ca fonctionne pour toutes les aciton, on passe le nom du template
            include_once PATH_TEMPLATE . "common/base.php";
            //    echo $this->twig->render("$templateName.twig", $vars); // render twig template
        }
    }


    //action de login
    public function login()
    {
        $template = 'login';
 
        if (isset($_POST['Users'])) {
            //dans le login, il faudra mettre le meme nom dans le formulaire
            $candidate =   UsersDao::findOneBy('login', $_POST['Users']['login']);

            //pour l'instant on passe le mdp en clair, TODO
            if ($candidate != null && $candidate->isPassword($_POST['Users']['password'])) {
                $this->setUser($candidate);
                header('Location: '.SiteUtil::url().'recipe/list');
                exit();
            }
        }
        $this->render($template);
        
    }


    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $_SESSION['userLogin'] = $user->getLogin();
        $this->user = $user;
        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        if (isset($_SESSION['userLogin'])) {
            $this->user = UsersDao::findOneBy('login', $_SESSION['userLogin']);
        }
        return $this->user;
    }
}
