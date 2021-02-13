<?php

class ArticleDao extends BaseDao{
  

    public static function findStockById($idArticle){
        $pdo = DatabaseUtil::getConnection();

        $stock = [];
        $idArticle = [$idArticle];
        $sql = $pdo->prepare("SELECT SUM(quantity) FROM lot WHERE idArticle=?");
        $sql->execute($idArticle);

        $idArticle = $sql->fetch();
        return $idArticle[0];
    }
}