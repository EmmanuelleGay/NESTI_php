<?php


class Lot extends BaseEntity{
    protected $idArticle;
    protected $SupplierOrder;
    protected $unitCost;
    protected $dateReception;
    protected $quantity;


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
     * Get the value of SupplierOrder
     */ 
    public function getSupplierOrder()
    {
        return $this->SupplierOrder;
    }

    /**
     * Set the value of SupplierOrder
     *
     * @return  self
     */ 
    public function setSupplierOrder($SupplierOrder)
    {
        $this->SupplierOrder = $SupplierOrder;

        return $this;
    }

    /**
     * Get the value of unitCost
     */ 
    public function getUnitCost()
    {
        return $this->unitCost;
    }

    /**
     * Set the value of unitCost
     *
     * @return  self
     */ 
    public function setUnitCost($unitCost)
    {
        $this->unitCost = $unitCost;

        return $this;
    }

    /**
     * Get the value of dateReception
     */ 
    public function getDateReception()
    {
        return $this->dateReception;
    }

    /**
     * Set the value of dateReception
     *
     * @return  self
     */ 
    public function setDateReception($dateReception)
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
