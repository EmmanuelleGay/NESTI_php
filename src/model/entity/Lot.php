<?php

class Lot extends BaseEntity
{
    private $idSupplierOrder;
    private $unitCost;
    private $dateReception;
    private $quantity;
    private $idArticle;
    
    /**
     * getArticle
     *
     * @return Article
     */
    public function getArticle(): ?Article
    {
        return $this->getRelatedEntity("Article");
    }
    
    /**
     * setArticle
     *
     * @param  mixed $a
     * @return void
     */
    public function setArticle(Article $a)
    {
        $this->setRelatedEntity($a);
    }

    
    /**
     * getImportations
     *
     * @return array
     */
    public function getImportations(): array
    {
        return $this->getRelatedEntities("Importation");
    }
    
    /**
     * getAdmins
     *
     * @return array
     */
    public function getAdmins(): array
    {
        return $this->getIndirectlyRelatedEntities("Users", "Importation", BaseDao::FLAGS['active']);
    }
    
    /**
     * getSubTotal
     *
     * @return void
     */
    public function getSubTotal()
    {
        return $this->getUnitCost() * $this->getQuantity();
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
     * Get the value of dateCreation
     */
    public function getDateReception()
    {
        return $this->dateReception;
    }

    /**
     * Set the value of dateCreation
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
}
