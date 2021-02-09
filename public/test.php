<?php


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

FormatUtil::dump($test->getIngredients());



//formatUtil::dump($value);

//echo $article->getPrice();

//$latestDate = strtotime()