<?php

class Ingredient extends Product{
    
    private $idIngredient;
    

    /**
     * getIngredientRecipes
     *
     * @param  mixed $options
     * @return array
     */
    public function getIngredientRecipes($options=[]): array{
        return $this->getRelatedEntities("IngredientRecipe",$options);
    }

    /**
     * Get the value of idIngredient
     */ 
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Set the value of idIngredient
     *
     * @return  self
     */ 
    public function setIdIngredient($idIngredient)
    {
        $this->idIngredient = $idIngredient;

        return $this;
    }
}