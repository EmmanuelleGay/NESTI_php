<?php

class Recipe extends BaseEntity
{
    private $idRecipe;
    private $dateCreation;
    private $name;
    private $difficulty;
    private $portions;
    private $flag;
    private $preparationTime;
    private $idChef;
    private $idImage;
    private $dateModification;
    
    /**
     * getComments
     *
     * @return array
     */
    public function getComments(): array
    {
        return $this->getRelatedEntities("Comment");
    }
        
    /**
     * getParagraphs
     *
     * @param  mixed $options
     * @return array
     */
    public function getParagraphs($options = []): array
    {
        return $this->getRelatedEntities("Paragraph", $options);
    }
        
    /**
     * getIngredientRecipes
     *
     * @return array
     */
    public function getIngredientRecipes(): array
    {
        return $this->getRelatedEntities("IngredientRecipe");
    }
    
    /**
     * getGrades
     *
     * @param  mixed $options
     * @return array
     */
    public function getGrades($options = []): array
    {
        return $this->getRelatedEntities("Grades", $options);
    }
    
    /**
     * getImage
     *
     * @return Image
     */
    public function getImage(): ?Image
    {
        return $this->getRelatedEntity("Image");
    }
    
    /**
     * setImage
     *
     * @param  mixed $i
     * @return void
     */
    public function setImage(Image $i)
    {
        $this->setRelatedEntity($i);
    }
    
    /**
     * getChef
     *
     * @return Chef
     */
    public function getChef(): ?Chef
    {
        return $this->getRelatedEntity("Chef");
    }
    
    /**
     * setChef
     *
     * @param  mixed $c
     * @return void
     */
    public function setChef(Chef $c)
    {
        $this->setRelatedEntity($c);
    }


    /**
     * Get the value of idImage
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * Set the value of idImage
     *
     * @return  self
     */
    public function setIdImage($idImage)
    {
        $this->idImage = $idImage;

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
     * Get the value of preparationTime
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Set the value of preparationTime
     *
     * @return  self
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /**
     * Get the value of flag
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set the value of flag
     *
     * @return  self
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get the value of portions
     */
    public function getPortions()
    {
        return $this->portions;
    }

    /**
     * Set the value of portions
     *
     * @return  self
     */
    public function setPortions($portions)
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * Get the value of difficulty
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set the value of difficulty
     *
     * @return  self
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

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
     * Get the value of dateCreation
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of dateCreation
     *
     * @return  self
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get the value of idChef
     */
    public function getIdChef()
    {
        return $this->idChef;
    }

    /**
     * Set the value of idChef
     *
     * @return  self
     */
    public function setIdChef($idChef)
    {
        $this->idChef = $idChef;

        return $this;
    }
    
    /**
     * getIngredients
     *
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->getIndirectlyRelatedEntities("Ingredient", "IngredientRecipe");
    }
    
    /**
     * getAverageGrade
     *
     * @return void
     */
    public function getAverageGrade()
    {
        $grade = null;

        $i = 0;
        $total = 0;
        foreach ($this->getGrades() as $grade) {
            $i++;
            $total += $grade->getRating();
        }
        return $i == 0 ? null : $total / $i;
    }
    
    /**
     * getTopOfRecipeByGrade
     *
     * @return void
     */
    public function getTopOfRecipeByGrade()
    {
       try{
        $pdo = DatabaseUtil::getConnection();
        $sql  ='CALL GetRecipeByGrade() ';
        
        $query = $pdo->query($sql);
        $result =  $query->fetchAll(PDO::FETCH_ASSOC);

       } 
       catch (Exception $e ){
        echo 'Exception reçue : ',  $e->getMessage();
       }

       return $result;
    }

    /**
     * Get the value of dateModification
     */ 
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set the value of dateModification
     *
     * @return  self
     */ 
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }
}
