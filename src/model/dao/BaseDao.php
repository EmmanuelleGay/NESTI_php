<?php

//require_once PATH_TOOLS . 'SiteUtil.php';
require_once PATH_TOOLS . "EntityUtil.php";
require_once PATH_TOOLS.'Database.php';
class BaseDao
{

    protected static  $tableName;
    protected static  $entityClass;
    protected static  $entityPrimaryKey;

    /**
     * findOneBy
     * create and return an entity corresponding to a given field name, and it's searched value
     * @param  String $key field name
     * @param  mixed $value to search
     * @return Objet if found, null otherwise
     */
    public static function findOneBy(String $key, $value)
    {
        $pdo = Database::connect();
        $req = $pdo->prepare("SELECT * FROM " . get_called_class()::$tableName . " WHERE $key = ?");
        $req->execute([$value]);
        $entity = $req->fetchObject(get_called_class()::$entityClass); // set entity properties to fetched column values
        if (!$entity) { // fetchObject returns boolean false if no row found, whereas we want null
            $entity = null;
        }
        return $entity;
    }

    /**
     * findById
     * create and return an entity corresponding to a given id
     * @param  mixed $id primary key
     * @return Objet if found, null otherwise
     */
    public static function findById($id)
    {
        return get_called_class()::findOneBy(get_called_class()::$entityPrimaryKey, $id);
    }

    /**
     * findAll
     * fetch all table rows, create and return matching entitiess
     * @return Array of entities (or empty if no rows in table)
     */
    public static function findAll(): array
    {
        $pdo = Database::connect();
        $req = $pdo->prepare("SELECT * FROM " . get_called_class()::$tableName . " ORDER BY ".get_called_class()::$entityPrimaryKey." DESC");
        $req->execute();

        $entities = [];
        while ($entity = $req->fetchObject(get_called_class()::$entityClass)) { // set entity properties to fetched column values
            $entities[] = $entity;
        };
        return $entities;
    }

    /**
     * findOneToMany
     * Get an entity that is joined in a one-to-many relationship to the entity in parameters
     * 
     * @param  mixed $startingEntity to base our search on
     * @param  mixed $joinedEntityClass Class of the joined entity to look for
     * @return void
     */
    public static function findOneToMany($startingEntity, String $joinedEntityClass)
    {
        // find dao class of the joined entity
        $joinedDaoClass = $joinedEntityClass::getDaoClass();

        // find column name of the joined entity's primary key
        $joinedClassPrimaryKey = $joinedDaoClass::$entityPrimaryKey;

        return $joinedDaoClass::findAllBy(
            // joined entity's primary key is the same one as starting entity's corresponding foreign key 
            $joinedClassPrimaryKey,
            EntityUtil::get($startingEntity, $joinedClassPrimaryKey)
        );
    }


    /**
     * findOneToOne
     * Get an entity that is joined in a one-to-one relationship to the entity in parameters
     * 
     * @param  mixed $startingEntity to base our search on
     * @param  mixed $joinedEntityClass Class of the joined entity to look for
     * @return void
     */
    public static function findOneToOne($startingEntity, String $joinedEntityClass)
    {
        // find dao class of the joined entity
        $joinedDaoClass = $joinedEntityClass::getDaoClass();

        // find column name of the joined entity's primary key
        $joinedClassPrimaryKey = $joinedDaoClass::$entityPrimaryKey;

        return $joinedDaoClass::findById(
            // joined entity's primary key is the same one as starting entity's corresponding foreign key 
            EntityUtil::get($startingEntity, $joinedClassPrimaryKey)
        );
    }

    /**
     * findOneBy
     * create and return a Objet corresponding to a given field name, and it's searched value
     * @param  String $key field name
     * @param  mixed $value to search
     * @return Objet if found, null otherwise
     */
    public static function findAllBy(String $key, $value)
    {
        $pdo = Database::connect();
        $req = $pdo->prepare("SELECT * FROM " . get_called_class()::$tableName . " WHERE $key = ?");
        $req->execute([$value]);

        $entities = [];
        while ($entity = $req->fetchObject(get_called_class()::$entityClass)) { // set entity properties to fetched column values
            $entities[] = $entity;
        };
        return $entities;
    }

    /**
     * saveOrUpdate
     * Save an entity to data source if it exists, or insert a new row if it doesn't
     * @param  mixed $entity
     * @return void
     */
    public static function saveOrUpdate(&$entity)
    {
        $pdo = Database::connect();
        if (!empty(EntityUtil::get($entity, get_called_class()::$entityPrimaryKey))) {
            get_called_class()::update($entity);  // if entity has a primary key set, it already exists in data source
        } else {
            $pk = get_called_class()::save($entity); // If no primary key set, insert new row
            EntityUtil::set($entity, get_called_class()::$entityPrimaryKey, $pk);
        }
    }

    /**
     * update
     * update the table row that corresponds to an entity
     * @param  mixed $entity to update in table
     * @return void
     */
    public static function update($entity)
    {
        $pdo = Database::connect();

        $columnNames = get_called_class()::getColumnNames();

        // update conditions are in the form "COLUMN_NAME = ?, COLUMN_NAME2 = ?, ..."
        $conditions = array_map(function ($columnName) {
            return "$columnName = ?";
        }, $columnNames);

        $sql = "UPDATE " . get_called_class()::$tableName . " SET " . implode(',', $conditions) . " WHERE " . get_called_class()::$entityPrimaryKey . " = ?";

        $q = $pdo->prepare($sql);

        $values = array_map( // Create a new array out of the column names
            function ($columnName) use ($entity) {
                return EntityUtil::get($entity, $columnName); // Each column name corresponds to an entity getter 
            },
            $columnNames
        );
        // Add primary key to list of values
        $values[] = EntityUtil::get($entity, get_called_class()::$entityPrimaryKey);

        $q->execute($values);
    }



    /**
     * save
     * insert a new row into data source that correpsonds to an entity
     * @param  mixed $entity to base new row on
     * @return int inserted entity's PK
     */
    public static function save($entity): int
    {
        $pdo = Database::connect();

        $columnNames = get_called_class()::getColumnNames(false);

        // Need a list of question marks of same size as the list of column names
        $questionMarks = array_map(function ($columnName) {
            return '?';
        }, $columnNames);

        $sql = "INSERT INTO " . get_called_class()::$tableName . " (" . implode(',', $columnNames) . ") 
        values(" . implode(',', $questionMarks) . ")";
        FormatUtil::dump($sql);
        $q = $pdo->prepare($sql);
        $values = array_map(function ($columnName) use ($entity) {
            return EntityUtil::get($entity, $columnName);
        }, $columnNames);
        $q->execute($values);

        return $pdo->lastInsertId(); // Last inserted ID is entity's id
    }


    /**
     * getColumnNames
     * get an array of column names, in the same order as they appear in the database schema
     * 
     * @param  bool $includePk include primary key in result?
     * @return void
     */
    public static function getColumnNames(bool $includePk = false): array
    {
        $pdo = Database::connect();
        $q = $pdo->prepare("DESCRIBE " . get_called_class()::$tableName);
        $q->execute();
        $columnNames = $q->fetchAll(PDO::FETCH_COLUMN);

        if (!$includePk) {
            // Get index of primary key in table schema (usually but not always first)
            $primaryKeyIndex = array_search(get_called_class()::$entityPrimaryKey, $columnNames);
            unset($columnNames[$primaryKeyIndex]); // unset it
        }

        // we must re-establish indexes starting from 0 in case we removed primary key
        return array_values($columnNames);
    }


    /**
     * delete
     * remove row in data source that corresponds to an Entity
     * @param  mixed $entity entity to remove from data source
     * @return void
     */
    public static function delete($entity)
    {
        $pdo = Database::connect();
        $sql = "DELETE FROM " . get_called_class()::$tableName . " WHERE " . get_called_class()::$entityPrimaryKey . " = ?";
        $q = $pdo->prepare($sql);
        $q->execute([EntityUtil::get($entity, get_called_class()::$entityPrimaryKey) ?? null]); // if entity doesn't exist, null instead of pk
    }
}
