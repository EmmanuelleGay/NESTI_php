<?php

use Symfony\Component\Form\Util\FormUtil;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//session_start();

include(__DIR__ . '/../config/constant.php');
include(__DIR__ . '/../src/tools/SiteUtil.php');


$article = articleDao::findById(1);

//formatUtil::dump($article->getArticlePrices());
$maxDate = 0;
$arrayArticlePrice = $article->getArticlePrices();

foreach ($arrayArticlePrice as $value) {
    $date =   strtotime($value->getDateStart());
    if ($maxDate <  $date) {
        $maxDate =  $date;
        $article = $value;
    }
}
$test = RecipeDao::findById(3);

//FormatUtil::dump($test->getIngredients());

$test = ArticleDao::findById(8);
 //FormatUtil::dump($test->getOrders(["ORDER"=>"dateCreation ASC"]));

//  //cde la plus récente => qui sera tout en haut donc indice 0


$test = UsersDao::findById(1);
//FormatUtil::dump($test->getRecipes((["ORDER"=>"dateCreation DESC"])));




//  //FormatUtil::dump($test->getOrders(["ORDER"=>"dateCreation DESC"])[0]);

//  //pour trouer une commande egale a une date précise
//  FormatUtil::dump($test->getOrders(["dateCreation"=>"2021-02-01 00:00:00"]));

//   //pour trouver une commande ente deux dates
//  FormatUtil::dump($test->getOrders(["dateCreation >"=>"2021-02-01 00:00:00","dateCreation <"=>"2021-02-07 00:00:00"]));

//  //récupère toutes les connection a une heure données => en faisant une boucle jusqu'à 24h => on récupère un tab de connection log => regarder la taille (count(array))
//  FormatUtil::dump(connectionLog::findAll(["HOUR(dateConnection)"=>11]));
// //FormatUtil::dump(OrdersDao::findAll(["ORDER"=>"dateCreation DESC"]));

//implémentation de la pagination
// // $queryOptions = ["LIMIT"=>2,"OFFSET"=>1];
// // FormatUtil::dump(OrdersDao::findAll($queryOptions));


// // $apprentice=UsersDao::findById(2);
// // $apprentice->makechef();

// //formatUtil::dump($apprentice);

// $test = RecipeDao::findById(3);
// //FormatUtil::dump($test->getIngredientRecipes());


// //formatUtil::dump($value);

// //echo $article->getPrice();

// //$latestDate = strtotime()

// $test = ProductDao::findById(6);
// $test->makeIngredient();
// //FormatUtil::dump($test);

// $test = UsersDao::findAllBy('lastName','Poirot');
// //FormatUtil::dump($test);

// $article = ArticleDao::findById(7);
// $orderDate = OrdersDao::findById(2);

// $price = ArticleDao::getPriceAt($article,$orderDate);
// FormatUtil::dump($price);


  $article = ArticleDao::findById(7);
  $order = OrdersDao::findById(2);
  $orderDate=$order->getDateCreation();

  $price = $article->getPriceAt($orderDate);
  FormatUtil::dump($orderDate);
  FormatUtil::dump($price);


//  $user=UsersDao::findById(1);
//  FormatUtil::dump($user->getSumOrder());

//  $order = OrdersDao::findById(2);
//  $date =  $order->getDateCreation();
//  $user = $order->getIdUsers();
//  FormatUtil::dump($user);
// FormatUtil::dump(strtotime($date));

$t = new Importation();
$t->setIdAdministrator(2);
$t->setIdArticle(7);
$t->setIdSupplierOrder(156);
ImportationDao::saveOrUpdate($t);
FormatUtil::dump($t);