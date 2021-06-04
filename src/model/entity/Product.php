<?php

class Product extends BaseEntity{

    private $idProduct;
    private $name;

    
    /**
     * getArticles
     *
     * @return array
     */
    public function getArticles(): array{
        return $this->getRelatedEntities("Article", BaseDao::FLAGS['active']);
    }
    

    /**
     * Get the value of idProduct
     */ 
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set the value of idProduct
     *
     * @return  self
     */ 
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * getIngredient
     *
     * @return void
     */
    public function getIngredient(){
        return $this->getChildEntity("Ingredient");
    }
    
    /**
     * makeIngredient
     *
     * @return void
     */
    public function makeIngredient(){
        return $this->makeChildEntity("Ingredient");
    }
    
    /**
     * isIngredient
     *
     * @return void
     */
    public function isIngredient(){
        return $this->getIngredient()!=null;
    }
    
    /**
     * getType
     *
     * @return void
     */
    public function getType(){
        return $this->isIngredient() ? 'ingrédient' : 'ustensil';
    }
}