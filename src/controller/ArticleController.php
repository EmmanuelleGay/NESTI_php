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
                    //ArticleDao::importArticleWithCsv($column[0], $column[1], $column[2], $column[3], $column[4]);

                    //check if unit exist and created it if not
                    $unit = UnitDao::findOneBy('name',$column['10']);
                    if($unit == null){
                        $unit = new Unit();
                        $unit->setName($column['10']);
                        UnitDao::save($unit);
                    }
                    $idUnit = $unit->getId();

                    //check if product exist and created it if not and if its a product and not a utensil
                    $product = ProductDao::findOneBy('name', $column['7']);
                    if($product == null && $column['7'] != null){
                        $product = new Product();
                        $product->setName($column['7']);
                        ProductDao::save($product);
                    }
                    $idProduct = $product->getId();

                    //check if article exist and created it if not
                    $article = ArticleDao::findById($column['6']);
                    if ($article == null){
                        $article = new Article();
                        $article->setId($column['6']);
                        $article->setUnitQuantity($column['8']);
                        $article->setFlag($column['9']);
                        $article->setIdUnit($idUnit);
                        $article->setIdProduct($idProduct);
                        $article->setNameToDisplay($column['7']);
                        ArticleDao::saveOrUpdate($article);

                        $articlePrice= new ArticlePrice();
                        $articlePrice->setDateStart($column['3']);
                        $articlePrice->setPrice($column['2']);
                        $articlePrice->setIdArticle($article->getId());
                        ArticlePriceDao::saveOrUpdate($articlePrice);
                    }
                    $idArticle = $article->getId();

                    //update others tables

                    $lot = new Lot();
                    $lot->setIdArticle($idArticle);
                    $lot->setIdSupplierOrder($column['0']);
                    $lot->setUnitCost($column['1']);
                    $lot->setDateReception($column['5']);
                    $lot->setQuantity($column['4']);
                    LotDao::saveOrUpdate($lot);
                    $idSupplier = $lot->getIdSupplierOrder();
                    
                    $i = new Importation();
                    $i->setIdArticle($idArticle);
                    $i->setIdAdministrator(UsersController::getLoggedInUser()->getId());
                    $i->setIdSupplierOrder($idSupplier);
                    ImportationDao::saveOrUpdate($i);
              }

            }
            $templateVars = ['message' => 'Importsuccess'];
            self::render($templateName,$templateVars);
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

    // public static function encodeArticleToDisplayWithAjax($article)
    // {
    //     //on va transformer le tableau php en tableau ajax
    //     //on passe en tableau php
    //     $arrayA = EntityUtil::toArray($article);

    //     //on passe en tableau json
    //     echo json_encode($arrayA);
    // }

    public static function order()
    {
        $templateName = 'order';
        //    static::render($templateName);

        static::render($templateName, [
            'entities' => OrdersDao::findAll()
        ]);
    }

    public static function orderDetailsAjax()
    {
        $idOrder = $_POST['orderId'];

        $order =  OrdersDao::findById($idOrder);
        $orderLines = $order->getOrderLines();
        $result = [];
        foreach ($orderLines as $key => $orderLine) {
            $currentLine = [];

            $currentLine["unitQuantity"]=  $orderLine->getArticle()->getUnitQuantity();
            $currentLine["unitName"] = $orderLine->getArticle()->getUnit()->getName();
            $currentLine["articleName"]= $orderLine->getArticle()->getProduct()->getName();
            $currentLine['quantity'] = $orderLine->getQuantity();
            $result[] = $currentLine;
        }
        // $arrayOrderLines =  EntityUtil::toArray($orderLines);
        echo json_encode($result);
    }
}
