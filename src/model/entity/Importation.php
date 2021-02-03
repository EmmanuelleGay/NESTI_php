<?php


class Importation extends BaseEntity{

    protected $idAdministrator;
    protected $idArticle;
    protected $idSupplierOrder;
    protected $importationDate;
    

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

    /**
     * Get the value of idArticle
     */ 
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set the value of idArticle
     *
     * @return  self
     */ 
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get the value of idSupplierOrder
     */ 
    public function getIdSupplierOrder()
    {
        return $this->idSupplierOrder;
    }

    /**
     * Set the value of idSupplierOrder
     *
     * @return  self
     */ 
    public function setIdSupplierOrder($idSupplierOrder)
    {
        $this->idSupplierOrder = $idSupplierOrder;

        return $this;
    }

    /**
     * Get the value of importationDate
     */ 
    public function getImportationDate()
    {
        return $this->importationDate;
    }

    /**
     * Set the value of importationDate
     *
     * @return  self
     */ 
    public function setImportationDate($importationDate)
    {
        $this->importationDate = $importationDate;

        return $this;
    }
}
