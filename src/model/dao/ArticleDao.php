<?php

class ArticleDao extends BaseDao
{


    public static function findStockById($idArticle)
    {
        $pdo = DatabaseUtil::getConnection();
        $tablename = LotDao::getTableName();

        $idArticle = [$idArticle];
        $sql = $pdo->prepare("SELECT SUM(quantity) FROM ".$tablename." WHERE idArticle=?");
        $sql->execute($idArticle);

        $idArticle = $sql->fetch();
        return $idArticle[0];
    }

    //     public static function getPriceAt($article, $date)
    //     {
    //         $pdo = DatabaseUtil::getConnection();

    //         $result = [];
    //    //     $date = [$date];
    //    //     $article = [$article];
    //         $sql = $pdo->prepare("SELECT * FROM articleprice a
    //         LEFT JOIN orderline o ON a.idArticle = o.idArticle
    //         LEFT JOIN orders o1 ON o.idOrders = o1.idOrders 
    //         WHERE a.dateStart < $date AND o.idArticle = $article 
    //         ORDER BY a.dateStart DESC");
    //         $sql->execute();

    //         $result = $sql->fetch();
    //         return $result[0] ?? null; // fetchObject returns boolean false if no row found, whereas we want null;
    //     }


    public static function importArticleWithCsv($unitQuantity, $flag, $idImage, $idUnit, $idProduct)
    {



        // $pdo = DatabaseUtil::getConnection();

        // $req = $pdo->prepare("INSERT INTO article (unitQuantiy,flag,idImage,idUnit,idProduct) VALUES (?,?,?,?,?)");

        // $req->execute(array(
        //     $unitQuantity,
        //     $flag,
        //     $idImage,
        //     $idUnit,     
        //     $idProduct
        // ));


    }
}
