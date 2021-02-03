<?php
require_once PATH_MODEL . 'dao/BaseDao.php';
require_once PATH_CTRL . 'BaseController.php';
require_once PATH_MODEL . 'entity/BaseEntity.php';
require_once PATH_ENTITY . 'Recipe.php';

require_once PATH_MODEL . 'dao/RecipeDao.php';




class RecipeController extends BaseController
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
            //si le templet eest nul(ex si on delete un article => aon applele le tmplate par dafault (ici la liste))
            $this->default();
        } else {
            // Add shared parameters to the existing ones
            $vars = array_merge($vars, [
                'baseUrl' => SiteUtil::url() . 'public', // absolute url of public folder
                'recipe' => $this->recipe,         // current user
                //    'controller'=>$this
                'templatePath' => PATH_TEMPLATE . "recipe/$templateName.php"
            ]);
            //pour que ca fonctionne pour toutes les aciton, on passe le nom du template
            include_once PATH_TEMPLATE . "common/base.php";
            //    echo $this->twig->render("$templateName.twig", $vars); // render twig template
        }
    }



    //action de login
    protected function login()
    {
        $template = 'login';

        if (isset($_POST['user'])) {
            //dans le login, il faudra mettre le meme nooùm dans le formulaire
            $candidate =   UserDao::findOneBy('login', $_POST['user']['login']);

            //pour l'instant on passe le mdp en clair, a changer
            //??=> si la valeur n'existe pas ou foire ca donne null
            if ($candidate != null && $candidate->isPassword($_POST['user']['password'])) {
                $this->setUser($candidate);
                //si c'est null ca redigirera sur l'action par défault de template
                $template = null;
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
            $this->user = UserDao::findOneBy('login', $_SESSION['userLogin']);
        }
        return $this->user;
    }
}
