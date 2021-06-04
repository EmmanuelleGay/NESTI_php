<?php
class Administrator extends Users{
    private $idAdministrator;

    
    /**
     * getImportations
     *
     * @return array
     */
    public function getImportations(): array{
        return $this->getRelatedEntities("Importation"); 
    }
    
    /**
     * getLots
     *
     * @return array
     */
    public function getLots(): array{
        return $this->getIndirectlyRelatedEntities("Lot", "Importation"); 
    }

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