<?php


class CommentDao extends BaseDao {


    //on scpécifie les noms de colonnes pour faire matcher 
    
    protected static $tableName = 'comment';
    protected static $entityClass ="Comment";
    protected static $entityPrimaryKey = 'idComment';

}