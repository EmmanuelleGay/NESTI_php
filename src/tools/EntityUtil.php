<?php

class EntityUtil
{    
    /**
     * get
     *
     * @param  mixed $entity
     * @param  mixed $propertyName
     * @return void
     */
    public static function get($entity, $propertyName)
    {
        $method =  'get' . ucFirst($propertyName);
        if(!method_exists($entity, $method) ) {
            throw new InvalidArgumentException("Undefined method \"$method\" in class ". get_class($entity));
        }

        return $entity->$method();
    }
    
    /**
     * set
     *
     * @param  mixed $entity
     * @param  mixed $propertyName
     * @param  mixed $propertyValue
     * @return void
     */
    public static function set(&$entity, $propertyName, $propertyValue)
    {
        $method =  'set' . ucFirst($propertyName);
        if(!method_exists($entity, $method) ) {
            throw new InvalidArgumentException("Undefined method \"$method\" in class ". get_class($entity));
        }
        return $entity->$method($propertyValue);
    }
    
    /**
     * setFromArray
     *
     * @param  mixed $entity
     * @param  mixed $properties
     * @return void
     */
    public static function setFromArray($entity, $properties)
    {
        foreach ($properties as $propertyName => $propertyValue) {
            static::set($entity, $propertyName, $propertyValue);
        }
    }
    
    /**
     * toArray
     *
     * @param  mixed $entity
     * @return void
     */
    public static function toArray($entity)
    {
        $result = [];
        if (is_array($entity)) {
            foreach ($entity as $e) {
                $result[] = static::toArray($e);
            }
        } else {
            $propertyNames = get_class($entity)::getDaoClass()::getColumnNames();
            foreach ($propertyNames as $propertyName) {
                $result[$propertyName] = static::get($entity, $propertyName);
            }
        }
        return $result;
    }
}
