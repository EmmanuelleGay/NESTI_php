<?php


class IngredientRecipe extends BaseEntity{

    protected $idProduct;
    protected $idRecipe;
    protected $quantiy;
    protected $recipePosition;
    protected $idUnit;

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
     * Get the value of idRecipe
     */ 
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }

    /**
     * Set the value of idRecipe
     *
     * @return  self
     */ 
    public function setIdRecipe($idRecipe)
    {
        $this->idRecipe = $idRecipe;

        return $this;
    }

    /**
     * Get the value of quantiy
     */ 
    public function getQuantiy()
    {
        return $this->quantiy;
    }

    /**
     * Set the value of quantiy
     *
     * @return  self
     */ 
    public function setQuantiy($quantiy)
    {
        $this->quantiy = $quantiy;

        return $this;
    }

    /**
     * Get the value of recipePosition
     */ 
    public function getRecipePosition()
    {
        return $this->recipePosition;
    }

    /**
     * Set the value of recipePosition
     *
     * @return  self
     */ 
    public function setRecipePosition($recipePosition)
    {
        $this->recipePosition = $recipePosition;

        return $this;
    }

    /**
     * Get the value of idUnit
     */ 
    public function getIdUnit()
    {
        return $this->idUnit;
    }

    /**
     * Set the value of idUnit
     *
     * @return  self
     */ 
    public function setIdUnit($idUnit)
    {
        $this->idUnit = $idUnit;

        return $this;
    }
}
