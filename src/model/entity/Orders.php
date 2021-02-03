<?php


class Orders extends BaseEntity{

    protected $idOrders;
    protected $flag;
    protected $creationDate;
    protected $idUser;

    /**
     * Get the value of idOrders
     */ 
    public function getIdOrders()
    {
        return $this->idOrders;
    }

    /**
     * Set the value of idOrders
     *
     * @return  self
     */ 
    public function setIdOrders($idOrders)
    {
        $this->idOrders = $idOrders;

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
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

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
}
