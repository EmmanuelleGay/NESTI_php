<?php

class ArticleController extends BaseEntityController
{

    protected static $entityClass = "Article";

    public static function callActionMethod($action)
    {

        method_exists(get_called_class(), $action) ?
            get_called_class()::$action() : // if action in URL exists, call it
            get_called_class()::list(); // else call default one
    }


    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);

        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'controllerSlug' =>  "article",
            'searchField' =>  "name"
        ]);
    }

    public static function confirmDelete()
    {
        static::getEntity()->setFlag('b');
        static::getDao()::saveOrUpdate(static::getEntity());

        header('Location: ' . SiteUtil::url() . 'article/list');
    }



    public static function importation()
    {
        $templateName = 'importation';
        //   $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];

        FormatUtil::dump($_POST);
        echo 'bordel';

        if (isset($_POST["Article"])) {

            echo 'coucou';
            FormatUtil::dump($_POST["Article"]);
            //    FormatUtil::dump(($_FILES["Article"]['file']));

            FormatUtil::dump($_POST["Article"]);
            FormatUtil::dump($_FILES);

            $fileName = $_FILES['Article']["fileCsv"]["tmp_name"];

            if ($_FILES["Article"]["fileCsv"]["size"] > 0) {

                $file = fopen($fileName, "r");
                while (($column = fgetcsv($file, 10000, ",")) != FALSE) {
                    ArticleDao::importArticleWithCsv($column[0], $column[1], $column[2], $column[3], $column[4]);
                }
            }

            //     header('Location:' . SiteUtil::url() . 'article/importation/');

        }
        static::render($templateName);
    }


    public static function edit()
    {
        $templateName = 'edit';
        $templateVars = ["isSubmitted" => !empty($_POST[self::getEntityClass()])];
        if (isset($_POST['Article'])) {
            $isvalid = true;
            if (!FormValidator::letters($_POST["Article"]["nameForUser"])) {
                $isvalid = false;
            }
            if($isvalid){
                echo 'valid';
                $entity = static::getEntity();
                $entity->setNameToDisplay($_POST["Article"]["nameForUser"]);
                $entity->setDateModification(date("Y-m-d H:i:s"));
                echo($entity->getDateModification());

                self::getDao()::saveOrUpdate($entity);
                header('Location:' . SiteUtil::url() . 'article/edit/' . $entity->getId() . "/success");
                exit();
            }
        }
        self::render($templateName, $templateVars);
    }
}
