<?php

class Article extends BaseEntity
{
    private $idArticle;
    private $unitQuantity;
    private $flag;
    private $dateCreation;
    private $dateModification;
    private $idImage;
    private $idUnit;
    private $idProduct;
    private $nameToDisplay;

    
    /**
     * getLastPrice
     *
     * @return String
     */
    public function getLastPrice(): String
    {
        $price = "";
        $maxDate = 0;
        $arrayArticlePrice = $this->getArticlePrices();

        foreach ($arrayArticlePrice as $value) {
            $date =   strtotime($value->getDateStart());
            if ($maxDate <  $date) {
                $maxDate =  $date;
                $price = $value->getPrice();
            }
        }
        if ($price == "") {
            $price = "-";
        }
        return $price;
    }
    
    /**
     * getArticlePriceAt
     *
     * @param  mixed $date
     */
    public function getArticlePriceAt($date){
        return $this->getArticlePrices(["dateStart <" => $date, "ORDER" => "dateStart DESC"])[0] ?? null;
    }

    
    /**
     * getPriceAt
     *
     * @param  mixed $value
     * @return String
     */
    public function getPriceAt($value): String
    {
        $price = 0;
        $maxDate = 0;
        $date = 0;
        $arrayArticlePrice = $this->getArticlePrices();

        foreach ($arrayArticlePrice as $ap) {
            $date =   $value;
            if ($maxDate <  $date) {
                $maxDate =  $date;
                $price = $ap->getPrice();
            }
        }
        if ($price == "") {
            $price = 0;
        }
        return $price;
    }
    
    /**
     * getPriceAt2
     *
     * @param  mixed $date
     * @return void
     */
    public function getPriceAt2($date){
        $this->getArticlePrices(["dateStart <"=>$date,"ORDER"=>"dateStart DESC"])[0] ?? null;
    }

    
    /**
     * getArticlePrices
     *
     * @param  mixed $options
     * @return array
     */
    public function getArticlePrices($options=[]): array
    {
        return $this->getRelatedEntities("ArticlePrice",$options);
    }
    
    /**
     * getLots
     *
     * @param  mixed $options
     * @return array
     */
    public function getLots($options=[]): array
    {
        return $this->getRelatedEntities("Lot",$options);
    }
    
    /**
     * getOrderLines
     *
     * @param  mixed $options
     * @return array
     */
    public function getOrderLines($options=[]): array
    {
        return $this->getRelatedEntities("OrderLine",$options);
    }
    
    /**
     * getProduct
     *
     * @return Product
     */
    public function getProduct(): ?Product
    {
        return $this->getRelatedEntity("Product");
    }
    
    /**
     * getUnit
     *
     * @return Unit
     */
    public function getUnit(): ?Unit
    {
        return $this->getRelatedEntity("Unit");
    }
    
    /**
     * getImage
     *
     * @return Image
     */
    public function getImage(): ?Image
    {
        return $this->getRelatedEntity("Image");
    }
    
    /**
     * setUnit
     *
     * @param  mixed $u
     * @return void
     */
    public function setUnit(Unit $u)
    {
        $this->setRelatedEntity($u);
    }

    
    /**
     * setProduct
     *
     * @param  mixed $p
     * @return void
     */
    public function setProduct(Product $p)
    {
        $this->setRelatedEntity($p);
    }

    
    /**
     * setImage
     *
     * @param  mixed $i
     * @return void
     */
    public function setImage(Image $i)
    {
        $this->setRelatedEntity($i);
    }
    
    /**
     * getOrders
     *
     * @param  mixed $options
     * @return array
     */
    public function getOrders($options = 'a'): array
    {
        return $this->getIndirectlyRelatedEntities("Orders", "OrderLine", $options);
    }

    /**
     * Get the value of idProduct
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set the value of idProduct
     *
     * @return  self
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get the value of idUnit
     */
    public function getIdUnit()
    {
        return $this->idUnit;
    }

    /**
     * Set the value of idUnit
     *
     * @return  self
     */
    public function setIdUnit($idUnit)
    {
        $this->idUnit = $idUnit;

        return $this;
    }

    /**
     * Get the value of idImage
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * Set the value of idImage
     *
     * @return  self
     */
    public function setIdImage($idImage)
    {
        $this->idImage = $idImage;

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

    /**
     * Get the value of unitQuantity
     */
    public function getUnitQuantity()
    {
        return $this->unitQuantity;
    }

    /**
     * Set the value of unitQuantity
     *
     * @return  self
     */
    public function setUnitQuantity($unitQuantity)
    {
        $this->unitQuantity = $unitQuantity;

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
     * Get the value of nameToDisplay
     */
    public function getNameToDisplay()
    {
        return $this->nameToDisplay;
    }

    /**
     * Set the value of nameToDisplay
     *
     * @return  self
     */
    public function setNameToDisplay($nameToDisplay)
    {
        $this->nameToDisplay = $nameToDisplay;

        return $this;
    }

    /**
     * Set the value of dateModification
     *
     * @return  self
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get the value of dateModification
     */ 
    public function getDateModification()
    {
        return $this->dateModification;
    }
    
    /**
     * getStockByArticle
     *
     * @return void
     */
    public function getStockByArticle()
    {
        $stock = ArticleDao::findStockById($this->getId());
        if ($stock == null) {
            $stock = "-";
        }
        return $stock;
    }
    
    /**
     * getStock
     *
     * @return void
     */
    public function getStock(){
        return (float) $this->getLots(["SELECT"=>"SUM(quantity)"])[0][0] ?? 0;
    }
    
    /**
     * getQuantitySold
     *
     * @return void
     */
    public function getQuantitySold(){
        $quantity = 0;

        foreach ($this->getOrderLines() as $orderLine){
            $quantity += $orderLine->getQuantity();
        }

        return $quantity;
    }
    
    /**
     * getTotalSales
     *
     * @return void
     */
    public function getTotalSales(){
        $total = 0;

        foreach ($this->getOrderLines() as $orderLine){
            $total += $orderLine->getSubTotal();
        }

        return $total;
    }
    
    /**
     * getQuantityPurchased
     *
     * @return void
     */
    public function getQuantityPurchased(){
        $quantity = 0;

        foreach ($this->getLots() as $lot){
            $quantity += $lot->getQuantity();
        }

        return $quantity;
    }
    
    /**
     * getTotalPurchases
     *
     * @return void
     */
    public function getTotalPurchases(){
        $total = 0;

        foreach ($this->getLots() as $lot){
            $total += $lot->getSubTotal();
        }

        return $total;
    }

}
