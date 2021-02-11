<?php

class UsersDao extends BaseDao{
 

    public static function findLatestConnection($idUser)
    {
        $pdo = DatabaseUtil::getConnection();

        $lastdateConnection = [];
        $idUser=[$idUser];
        $sql = $pdo->prepare("SELECT MAX(dateConnection) FROM connectionlog WHERE idUsers = ?");
        $sql->execute($idUser);

        $lastdateConnection = $sql->fetch();
        return $lastdateConnection[0];
    }
}