<?php

namespace Admin\Project\Controllers;

use Admin\Project\Models\StockMoviment;


class StockMovimentController
{

    private $idProduct;
    private $idUser;
    private $type;
    private $quantityStock;
    private $ObservationStock;


    /**
     * Get the value of idProduct
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set the value of idProduct
     */
    public function setIdProduct($idProduct): self
    {
        $this->idProduct = $idProduct;

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
     */
    public function setIdUser($idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     */
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of quantityStock
     */
    public function getQuantityStock()
    {
        return $this->quantityStock;
    }

    /**
     * Set the value of quantityStock
     */
    public function setQuantityStock($quantityStock): self
    {
        $this->quantityStock = $quantityStock;

        return $this;
    }

    /**
     * Get the value of ObservationStock
     */
    public function getObservationStock()
    {
        return $this->ObservationStock;
    }

    /**
     * Set the value of ObservationStock
     */
    public function setObservationStock($ObservationStock): self
    {
        $this->ObservationStock = $ObservationStock;

        return $this;
    }

    public function createStockMovimentation()
    {
        $data_stock = [
            "idProduct" => $this->getIdProduct(),
            "idUser" => $this->getIdUser(),
            "typeStock" => $this->getType(),
            "quantityStock" => $this->getQuantityStock(),
            "ObservationStock" => $this->getObservationStock()
        ];

        $stockConfig = new StockMoviment();

        $stockConfig->saveDatasStockMoviment($data_stock);
        
    }

    
}
