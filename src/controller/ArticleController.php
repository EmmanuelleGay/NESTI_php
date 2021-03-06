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

        if (isset($_FILES["fileCsv"])) {

            $fileName = $_FILES["fileCsv"]["tmp_name"];

            if ($_FILES["fileCsv"]["size"] > 0) {

                $file = fopen($fileName, "r");
                while (($column = fgetcsv($file, 10000, ";")) != FALSE) {
                    //           ArticleDao::importArticleWithCsv($column[0], $column[1], $column[2], $column[3], $column[4]);

                    $a = new Article();
                    $a->setUnitQuantity($column[0]);
                    $a->setFlag($column[1]);
                    $a->setIdImage($column[2]);
                    $a->setIdUnit($column[3]);
                    $a->setIdProduct($column[4]);

                    ArticleDao::saveOrUpdate($a);

                    $idArticle = $a->getId();

                    $i = new Importation();
                    $i->setIdArticle($idArticle);
                    $i->setIdAdministrator(UsersController::getLoggedInUser()->getId());
                    $i->setIdSupplierOrder($column[5]);
                    //TO DO ---- PAS OPERATIONNEL
                 //   ImportationDao::saveOrUpdate($i);

                }

                //   FormatUtil::dump($entity);
            }

            header('Location:' . SiteUtil::url() . 'article/importation');
            exit();
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
            if ($isvalid) {
                echo 'valid';
                $entity = static::getEntity();
                $entity->setNameToDisplay($_POST["Article"]["nameForUser"]);
                $entity->setDateModification(date("Y-m-d H:i:s"));
                //      echo($entity->getDateModification());

                self::getDao()::saveOrUpdate($entity);
                header('Location:' . SiteUtil::url() . 'article/edit/' . $entity->getId() . "/success");
                exit();
            }
        }
        self::render($templateName, $templateVars);
    }

    public static function encodeArticleToDisplayWithAjax($article)
    {
        //on va transformer le tableau php en tableau ajax
        //on passe en tableau php
        $arrayA = EntityUtil::toArray($article);

        //on passe en tableau json
        echo json_encode($arrayA);
    }

    public static function order()
    {
        $templateName = 'order';
    //    static::render($templateName);

        static::render($templateName, [
            'entities' => OrdersDao::findAll()
        ]);
    }

}
