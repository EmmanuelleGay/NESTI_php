<?php


class Comment extends BaseEntity
{

    protected $idComment;
    protected $idRecipe;
    protected $idUser;
    protected $idModerator;
    protected $commentTitle;
    protected $commentContent;
    protected $dateCreation;
    protected $flag;

    //faire getters et setters + methodes de base + methodes de relation (ex : unGetRecipe)


    //retorune un objet de type recette
    public function getRecipe()
    {
        return RecipeDao::findById($this->idRecipe);
    }

    //idnetique mais on est pas obligé de connaitre le nom de l'id => le recipe est jsute le nom de la classe
    public function getRecipe2()
    {
        //return CommentDao::findOneToOne($this,"Recipe");

        //option deux, car on n'a une methode pour récupérer le dao de la class en cours
        return self::getDAOClass()::findOneToOne($this,"Recipe");
    }


    /**
     * Get the value of idComment
     */ 
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * Set the value of idComment
     *
     * @return  self
     */ 
    public function setIdComment($idComment)
    {
        $this->idComment = $idComment;

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
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of idModerator
     */ 
    public function getIdModerator()
    {
        return $this->idModerator;
    }

    /**
     * Set the value of idModerator
     *
     * @return  self
     */ 
    public function setIdModerator($idModerator)
    {
        $this->idModerator = $idModerator;

        return $this;
    }

    /**
     * Get the value of commentTitle
     */ 
    public function getCommentTitle()
    {
        return $this->commentTitle;
    }

    /**
     * Set the value of commentTitle
     *
     * @return  self
     */ 
    public function setCommentTitle($commentTitle)
    {
        $this->commentTitle = $commentTitle;

        return $this;
    }

    /**
     * Get the value of commentContent
     */ 
    public function getCommentContent()
    {
        return $this->commentContent;
    }

    /**
     * Set the value of commentContent
     *
     * @return  self
     */ 
    public function setCommentContent($commentContent)
    {
        $this->commentContent = $commentContent;

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
}
