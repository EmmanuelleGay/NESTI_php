<?php
//require_once PATH_MODEL.'entity/BaseEntity.php';


class RecipeDao extends BaseDao {

    protected static $tableName = 'recipe';
    protected static $entityClass ="Recipe";
    protected static $entityPrimaryKey = 'idRecipe';

}