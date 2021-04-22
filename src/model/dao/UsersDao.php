<?php

class UsersDao extends BaseDao
{
    // public static function findLastConnection($value, $flag=null)
    // {
    //     $pdo = DatabaseUtil::getConnection();
    //     $sql = "SELECT MAX(dateConnection) FROM " . self::getTableName() . " WHERE idUsers = ?";
    //     $values = [$value];

    //     if ( $flag != null){
    //         $sql .= " AND flag = ?";
    //         $values[] = $flag;
    //     }

    //     $req = $pdo->prepare($sql);
    //     $req->execute($values);
    //     $lastConnectionDate = $req->fetch(); // set entity properties using fetched values

    //     return $lastConnectionDate[0] ?? null; // fetchObject returns boolean false if no row found, whereas we want null
    // }

    public static function findLatestConnection($idUser)
    {
        $pdo = DatabaseUtil::getConnection();
        $tableName = ConnectionLogDao::getTableName();

        $lastdateConnection = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT MAX(dateConnection) FROM " . $tableName . " WHERE idUsers = ?");
        $sql->execute($idUser);

        $lastdateConnection = $sql->fetch();
        return $lastdateConnection[0] ?? null; // fetchObject returns boolean false if no row found, whereas we want null;
    }

    public static function findRecipesNumber($idUser)
    {
        $pdo = DatabaseUtil::getConnection();
        $table = RecipeDao::getTableName();

        $recipeNumber = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT COUNT(*) FROM " .$table ." WHERE idChef = ?");
        $sql->execute($idUser);

        $recipeNumber = $sql->fetch();
        return $recipeNumber[0] ?? null;
    }

    public static function findLastRecipe($idUser)
    {

        $pdo = DatabaseUtil::getConnection();
        $table = RecipeDao::getTableName();

        $lastRecipe = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT MAX(dateCreation) FROM " .$table ." WHERE idChef = ? AND flag ='a'");

        $sql->execute($idUser);

        $lastRecipe = $sql->fetch();
        return $lastRecipe[0] ?? null;
    }

    public static function findOrdersNumber($idUser)
    {
        $pdo = DatabaseUtil::getConnection();

        $orderNumber = [];
        $table = OrdersDao::getTableName();
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT COUNT(*) FROM " . $table .  " WHERE idUsers = ?");
        $sql->execute($idUser);

        $orderNumber = $sql->fetch();
        return $orderNumber[0] ?? null;
    }

    public static function findLastOrder($idUser)
    {

        $pdo = DatabaseUtil::getConnection();
        $table = OrdersDao::getTableName();
        $lastOrder = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT MAX(dateCreation) FROM " . $table .  " WHERE idUsers = ?");

        $sql->execute($idUser);

        $lastOrder = $sql->fetch();
        return $lastOrder[0] ?? null;
    }

    public static function findImportationsNumber($idUser)
    {
        $pdo = DatabaseUtil::getConnection();
        $table = ImportationDao::getTableName();
        $importationNumber = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT COUNT(*) FROM " . $table .  " WHERE idAdministrator = ?");
        $sql->execute($idUser);

        $importationNumber = $sql->fetch();
        return $importationNumber[0] ?? null;
    }


    public static function findLastImportation($idUser)
    {
        $pdo = DatabaseUtil::getConnection();
        $table = ImportationDao::getTableName();
        $lastOrder = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT MAX(dateImportation) FROM " . $table .  " WHERE idAdministrator = ?");

        $sql->execute($idUser);

        $lastImportation = $sql->fetch();
        return $lastImportation[0] ?? null;
    }


    public static function findBlockedCommentNumber($idUser)
    {
        $pdo = DatabaseUtil::getConnection();
        $BlockedCommentNumber = [];
        $table = CommentDao::getTableName();
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT COUNT(*) FROM " . $table .  " WHERE idModerator = ? AND flag ='b' ");
        $sql->execute($idUser);

        $BlockedCommentNumber = $sql->fetch();
        return $BlockedCommentNumber[0] ?? null;
    }

    public static function findApprouvedCommentNumber($idUser)
    {
        $pdo = DatabaseUtil::getConnection();
        $table = CommentDao::getTableName();
        $ApprouvedCommentNumber = [];
        $idUser = [$idUser];
        $sql = $pdo->prepare("SELECT COUNT(*) FROM " . $table .  " WHERE idModerator = ? AND flag ='a' ");
        $sql->execute($idUser);

        $ApprouvedCommentNumber = $sql->fetch();
        return $ApprouvedCommentNumber[0] ?? null;
    }
}
