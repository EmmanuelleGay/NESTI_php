<?php
//pour récupérer la propriété privée (ajoute un get) => ex au lieu de faire getFirstname => on peu faire $firstaneme
//contrsuit le getter équiv lnet

class EntityUtil{
    public static function get($entity, $propertyName){
        return $entity->{'get' . ucFirst($propertyName)}();
    }

    public static function set(&$entity, $propertyName, $propertyValue){
        return $entity->{'set' . ucFirst($propertyName)}($propertyValue);
    }
}