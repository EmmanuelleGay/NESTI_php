<?php

class ArticleController extends BaseEntityController
{

    protected static $entityClass = "Article";

    
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
     * setupTemplateVars
     *
     * @param  mixed $vars
     * @param  mixed $templates
     * @return void
     */
    public static function setupTemplateVars(&$vars, &$templates)
    {
        parent::setupTemplateVars($vars, $templates);

        // Add shared parameters to the existing ones
        $vars = array_merge($vars, [
            'controllerSlug' =>  "article",
            'searchField' =>  "name"
        ]);
    }
 
    /**
     *  delete article into database
     *
     * @return void
     */
    public static function confirmDelete()
    {
        static::getEntity()->setFlag('b');
        static::getDao()::saveOrUpdate(static::getEntity());

        header('Location: ' . SiteUtil::url() . 'article/list');
    }


    /**
     * import CSV files with articles and orders, and insert into db
     */
    public static function importation()
    {
        $templateName = 'importation';
        $templateVars = [];
        $templateVars["lineImportations"] = [];
        if (isset($_FILES["fileCsv"])) {

            $fileName = $_FILES["fileCsv"]["tmp_name"];

            if ($_FILES["fileCsv"]["size"] > 0) {

                $file = fopen($fileName, "r");
                while (($column = fgetcsv($file, 10000, ";")) != FALSE) {

                    //check if unit exist and created it if not
                    $unit = UnitDao::findOneBy('name', $column['10']);
                    if ($unit == null) {
                        $unit = new Unit();
                        $unit->setName($column['10']);
                        UnitDao::save($unit);
                    }
                    $idUnit = $unit->getId();

                    //check if product exist and created it if not
                    $product = ProductDao::findOneBy('name', $column['7']);
                    if ($product == null && $column['7'] != 'null') {
                        $product = new Product();
                        $product->setName($column['7']);
                        ProductDao::save($product);

                        //check if its a ingredient or utensil and created it if necessary
                        if ($column['11'] != 'null') {
                            $product->makeIngredient();
                        }
                    }
                    $idProduct = $product->getId();

                    //check if article exist and created it if not
                    $article = ArticleDao::findById($column['6']);
                    if ($article == null) {
                        $article = new Article();
                        $article->setId($column['6']);
                        $article->setUnitQuantity($column['8']);
                        $article->setFlag($column['9']);
                        $article->setIdUnit($idUnit);
                        $article->setIdProduct($idProduct);
                        $article->setNameToDisplay($column['7']);
                        ArticleDao::saveOrUpdate($article);
                    }
                    $idArticle = $article->getId();

                    $articlePrice = new ArticlePrice();

                    $newDateStart = $column['3'];
                    $newDateStart = strtotime($newDateStart);
                    $newDateStart = date('Y-m-d H:i:s', $newDateStart);
                    $articlePrice->setDateStart($newDateStart);

                    $articlePrice->setPrice($column['2']);
                    $articlePrice->setIdArticle($article->getId());
                    ArticlePriceDao::saveOrUpdate($articlePrice);
                    
                    //update others tables

                    $lot = new Lot();
                    $lot->setIdArticle($idArticle);
                    $lot->setIdSupplierOrder($column['0']);
                    $lot->setUnitCost($column['1']);

                    $dateReception = $column['5'];
                    $dateReception = strtotime($dateReception);
                    $dateReception = date('Y-m-d H:i:s', $dateReception);
                    $lot->setDateReception($dateReception);

                    $lot->setQuantity($column['4']);
                    LotDao::saveOrUpdate($lot);
                    $idSupplier = $lot->getIdSupplierOrder();

                    $i = new Importation();
                    $i->setIdArticle($idArticle);
                    $i->setIdAdministrator(UsersController::getLoggedInUser()->getId());
                    $i->setIdSupplierOrder($idSupplier);
                    ImportationDao::saveOrUpdate($i);

                    //to be able to display details after importation
                    $lineImportation = [];
                    $lineImportation["idArticle"] = $idArticle;
                    $lineImportation["article"] =  $article->getNameToDisplay();
                    $lineImportation["stock"] =  $lot->getQuantity();
                    $templateVars["lineImportations"][] =  $lineImportation;
                }
            }
            self::render($templateName, $templateVars);
        }

        static::render($templateName);
    }

    /**
     * Save or update article
     */
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


                if (isset($_FILES["linkImage"]["tmp_name"]) && $_FILES["linkImage"]["error"] == 0) {

                    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                    $filename = $_FILES["linkImage"]["name"];
                    $filetype = $_FILES["linkImage"]["type"];
                    $filesize = $_FILES["linkImage"]["size"];

                    //Valid file's extension
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if (!array_key_exists($ext, $allowed)) {
                        die("Erreur : Veuillez sélectionner un format de fichier valide.");
                    }

                    //  check size of file - 5 m max
                    $maxsize = 5 * 1024 * 1024;
                    if ($filesize > $maxsize) {
                        die("Erreur: La taille du fichier est supérieure à la limite autorisée.");
                    }

                    // check MIME type of the file
                    $imageFolder = SiteUtil::toAbsolute() . "public/images/articles/" . $_FILES["linkImage"]["name"];
                    if (in_array($filetype, $allowed)) {
                        move_uploaded_file($_FILES["linkImage"]["tmp_name"], $imageFolder);
                    }

                    //if image is valid, insert into db
                    if (isset($_FILES["linkImage"]["tmp_name"])) {
                        $idImage = $entity->getIdImage();
                        if($idImage==null){
                            $image = new Image();
                        }
                        else {
                            $image = ImageDao::findById($idImage);
                        }
                     
                        $arrayNameImage = explode(".", $_FILES["linkImage"]["name"]);
                        $image->setName($arrayNameImage[0]);
                        $image->setFileExtension($arrayNameImage[1]);
                        ImageDao::saveOrUpdate($image);
                        $idImage=$image->getId();
                        $entity->setIdImage($idImage);
                    }
                }


                self::getDao()::saveOrUpdate($entity);
                header('Location:' . SiteUtil::url() . 'article/edit/' . $entity->getId() . "/success");
                exit();
            }
        }
        self::render($templateName, $templateVars);
    }

    /**
     * show page order
     */
    public static function order()
    {
        $templateName = 'order';
        static::render($templateName, [
            'entities' => OrdersDao::findAll()
        ]);
    }


     /**
      * orderDetailsAjax
      * to display details of order on a click
      * @return void
      */
     public static function orderDetailsAjax()
    {
        $idOrder = $_POST['orderId'];

        $order =  OrdersDao::findById($idOrder);
        $orderLines = $order->getOrderLines();
        $result = [];
        foreach ($orderLines as $key => $orderLine) {
            $currentLine = [];

            $currentLine["unitQuantity"] =  $orderLine->getArticle()->getUnitQuantity();
            $currentLine["unitName"] = $orderLine->getArticle()->getUnit()->getName();
            $currentLine["articleName"] = $orderLine->getArticle()->getProduct()->getName();
            $currentLine['quantity'] = $orderLine->getQuantity();
            $result[] = $currentLine;
        }
        echo json_encode($result);
    }
}
