<?php
class Moderator extends Users{
    private $idModerator;

    
    /**
     * getApprovedComment
     *
     * @return array
     */
    public function getApprovedComment(): array{
        return $this->getRelatedEntities("Comment");
    }
    
    /**
     * setApprovedComment
     *
     * @param  mixed $c
     * @return void
     */
    public function setApprovedComment(Comment $c){
        $this->setRelatedEntity($c);
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
}