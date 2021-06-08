<?php


class BaseController
{
    
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
        get_called_class()::error(); // else call default one
    }
    
    /**
     * processAction
     *
     * @param  mixed $forceAction
     * @return void
     */
    public static function processAction($forceAction = null)
    {
        SiteUtil::sanitize($_POST);    // need recursive sanitizing for multidimensional array
        SiteUtil::sanitize($_GET);
      

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
        $location = filter_input(INPUT_GET, 'loc', FILTER_SANITIZE_STRING);


        if ($forceAction != null) {
            $action = $forceAction;
        }

        get_called_class()::callActionMethod($action);
    }


    /**
     * render
     * renders a template
     * @param  mixed $templateName template name , or null to redirect to default action
     * @return void
     */
    protected static function render($templates, $vars = [])
    {
        if ($templates == null) {
            //si le templet est nul(ex si on delete un article => on applele le tmplate par dafault (ici la liste))
            self::error();
        } else {
            if (!is_array($templates)) {
                $templates = ['action' => $templates, 'base' => 'common/base'];
            }

            get_called_class()::setupTemplateVars($vars, $templates);

            //repars a la racine du porjet
            include_once SiteUtil::toAbsolute('view/' . $templates['base'] . '.php');
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
        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'baseUrl' => SiteUtil::url(), // absolute url of public folder
            'controller' => self::class,         // current user
            'templatePath' => SiteUtil::toAbsolute() . PATH_TEMPLATE . $templates['action'] . ".php",
            'loggedInUser' => UsersController::getLoggedInUser(),
            'stylesheet' => static::getAssetName(),
            'js' => static::getAssetName(),
            //en prod il faudra chnager pour avoir la bonne version
            'version' => random_int(0,80000000000)
        ]);
    }    


    /**
     * getAssetName
     *
     * @return void
     */
    public static function getAssetName()
    {
        $name = static::class;
        return strtolower(substr($name, 0, strlen($name) - 10));
    }

    
   
    /**
     * error
     *
     * @return void
     */
    protected static function error()
    {
        self::render('error/error404');
    }
}
