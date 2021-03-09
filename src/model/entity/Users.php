<?php

class Users extends BaseEntity
{
    private $idUsers;
    private $lastName;
    private $firstName;
    private $email;
    private $passwordHash;
    private $flag;
    private $dateCreation;
    private $login;
    private $address1;
    private $address2;
    private $zipCode;
    private $idCity;

    public function getOrders(): array
    {
        return $this->getRelatedEntities("Orders");
    }

    public function getConnectionLogs(): array
    {
        return $this->getRelatedEntities("ConnectionLog");
    }


    public function getComments(): array
    {
        return $this->getRelatedEntities("Comment", BaseDao::FLAGS['active']);
    }

    // public function getRecipes(): array
    // {
    //     return $this->getIndirectlyRelatedEntities("Recipe", "Grades", BaseDao::FLAGS['active']);
    // }

    public function getRecipes(): array
    {
        return $this->getRelatedEntities("Comment", BaseDao::FLAGS['active']);
    }

    public function getCity(): ?City
    {

        return $this->getRelatedEntity("City");
    }

    public function setCity(City $c)
    {
        $this->setRelatedEntity($c);
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

    public function getState()
    {
        $state = "";
        if ($this->getFlag() == 'a') {
            $state = 'Actif';
        } else if ($this->getFlag() == 'w') {
            $state = 'En attente';
        } else {
            $state = 'Bloqué';
        }
        return $state;
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
     * Get the value of passwordHash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set the value of passwordHash
     *
     * @return  self
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of firtName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the value of firtName
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

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

    /**
     * Get the value of login
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    public function isPassword(String $plainTextPassword)
    {
        return password_verify($plainTextPassword, $this->getPasswordHash());
    }



    public function setPasswordHashFromPlaintext($plaintextPassword)
    {
        $this->setPasswordHash(password_hash($plaintextPassword, PASSWORD_DEFAULT));
    }


    /**
     * Get the value of address1
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set the value of address1
     *
     * @return  self
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get the value of address2
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set the value of address2
     *
     * @return  self
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get the value of zipCode
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set the value of zipCode
     *
     * @return  self
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get the value of idCity
     */
    public function getIdCity()
    {
        return $this->idCity;
    }

    /**
     * Set the value of idCity
     *
     * @return  self
     */
    public function setIdCity($idCity)
    {
        $this->idCity = $idCity;

        return $this;
    }

    // on récupère le chef => si null => n'est pas chef
    public function getChef()
    {
        // si on veut que les actifs, on pourrat ajouter 'a" a la fin après getId()
        return ChefDao::findById($this->getId());
        // OPTION 2    return ChefDao::findAll(["flag"=>'a',"idChef"=>$this->getId()]);
    }
    //retourne un boolean
    public function isChef()
    {
        return $this->getChef() != null;
    }

    // a vérifier si ca fonctionne
    public function makeChef()
    {
        if (!$this->isChef()) {
            $chef = new Chef();
            $chef->setId($this->getId());
            ChefDao::save($chef);
        }
    }

    public function isModerator()
    {
        return $this->getModerator() != null;
    }

    public function makeModerator()
    {
        if (!$this->isModerator()) {
            $moderator = new Moderator();
            $moderator->setId($this->getId());
            ModeratorDao::save($moderator);
        }
    }

    public function getModerator()
    {
        return ModeratorDao::findById($this->getId());
    }

    public function isAdministrator()
    {
        return $this->getAdministrator() != null;
    }

    public function makeAdministrator()
    {
        if (!$this->isAdministrator()) {
            $administrator = new Administrator();
            $administrator->setId($this->getId());
            AdministratorDao::save($administrator);
        }
    }

    public function getAdministrator()
    {
        return AdministratorDao::findById($this->getId());
    }

    public function getRoles()
    {
        $roles = [];
        if ($this->isChef()) {
            $roles[] = "Chef";
        }
        if ($this->isModerator()) {
            $roles[] = "Moderateur";
        }
        if ($this->isAdministrator()) {
            $roles[] = "Administrateur";
        }
        return $roles;
    }

    public function getLatestConnection()
    {
        $lastDate = UsersDao::findLatestConnection($this->getId());
        if ($lastDate != null) {
            $lastDate = date_create($lastDate);
            $lastDate = date_format($lastDate, 'd/m/Y H:i:s');
        } else {
            $lastDate = "-";
        }
        return $lastDate;
    }

    public function getRecipesNumber()
    {
        $result =  UsersDao::findRecipesNumber($this->getId());
        if ($result == null) {
            $result = 0;
        }
        return $result;
    }

    public function getOrdersNumber()
    {
        $result =  UsersDao::findOrdersNumber($this->getId());
        if ($result == null) {
            $result = 0;
        }
        return $result;
    }

    public function getImportationNumber()
    {
        $result =  UsersDao::findImportationsNumber($this->getId());
        if ($result == null) {
            $result = 0;
        }
        return $result;
    }

    public function getLastImportation()
    {
        $result = UsersDao::findLastImportation($this->getId());
        if ($result == null) {
            $result = "-";
        }
        return $result;
    }

    public function getBlockedCommentNumber()
    {
        $result =  UsersDao::findBlockedCommentNumber($this->getId());
        if ($result == null) {
            $result = 0;
        }
        return $result;
    }

    public function getApprouvedCommentNumber()
    {
        $result =  UsersDao::findApprouvedCommentNumber($this->getId());
        if ($result == null) {
            $result = 0;
        }
        return $result;
    }

    public function getLastRecipe()
    {
        $result =  UsersDao::findLastRecipe($this->getId());
        if ($result == null) {
            $result = "-";
        }
        return $result;
    }

    public function getlastOrder()
    {
        $result =  UsersDao::findLastOrder($this->getId());
        if ($result == null) {
            $result = "-";
        }
        return $result;
    }

    public function getSumOrder()
    {
        $result = 0.0;
        $price = 0;
        $orders = $this->getOrders();

        foreach ($orders as $o) {
            $orderLines = $o->getOrderLines();
            foreach ($orderLines as $ol) {
                $orderDate = $o->getDateCreation();

                $quantity = $ol->getQuantity();

                $article = $ol->getArticle();
                $price = $article->getPriceAt($orderDate);
            }
            if (isset($quantity)) {
                $result +=  $quantity * $price;
            }
        }
        return $result . " €";
    }
}
