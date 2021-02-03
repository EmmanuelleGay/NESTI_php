<?php


class Administrator extends User{
    protected $idAdministrator;

    

    /**
     * Get the value of idAdministrator
     */ 
    public function getIdAdministrator()
    {
        return $this->idAdministrator;
    }

    /**
     * Set the value of idAdministrator
     *
     * @return  self
     */ 
    public function setIdAdministrator($idAdministrator)
    {
        $this->idAdministrator = $idAdministrator;

        return $this;
    }
}