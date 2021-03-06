<?php

class Orders extends BaseEntity{
    private $idOrders;
    private $flag;
    private $dateCreation;
    private $idUsers;

    
    public function getOrderLines(): array{
        return $this->getRelatedEntities("OrderLine");
    }
    

    // public function getUsers(): array{
    //     return $this->getRelatedEntities("Users");
    // }

    
    public function getUsers(): ?Users{
        return $this->getRelatedEntity("Users");
    }

    public function setUsers(Users $user){
        $this->setRelatedEntity($user);
    }

    /**
     * Get the value of idOrdes
     */
    public function getIdOrders()
    {
        return $this->idOrders;
    }

    /**
     * Set the value of idOrdes
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
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get the value of idUser
     */
    public function getIdUsers()
    {
        return $this->idUsers;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */
    public function setIdUsers($idUsers)
    {
        $this->idUsers = $idUsers;

        return $this;
    }


    
}