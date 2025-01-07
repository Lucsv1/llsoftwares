<?php
namespace Admin\Project\Controllers;

use Admin\Project\Models\Products;

class ProductsController
{

    private $nameProduct;
    private $priceProduct;
    private $descriptionProduct;
    private $quantityStorage;

    public function getNameProduct()
    {
        return $this->nameProduct;
    }

    public function getPriceProduct()
    {
        return $this->priceProduct;
    }

    public function setNameProduct($nameProduct)
    {
        $this->nameProduct = $nameProduct;

        return $this;
    }

    public function setPriceProduct($price)
    {
        $this->priceProduct = $price;

        return $this;
    }

    /**
     * Get the value of descriptionProduct
     */
    public function getDescriptionProduct()
    {
        return $this->descriptionProduct;
    }

    /**
     * Set the value of descriptionProduct
     */
    public function setDescriptionProduct($descriptionProduct): self
    {
        $this->descriptionProduct = $descriptionProduct;

        return $this;
    }

    /**
     * Get the value of quantityStorage
     */
    public function getQuantityStorage()
    {
        return $this->quantityStorage;
    }

    /**
     * Set the value of quantityStorage
     */
    public function setQuantityStorage($quantityStorage): self
    {
        $this->quantityStorage = $quantityStorage;

        return $this;
    }


    public function createProduct()
    {

        $data_product = [
            "nameProduct" => $this->getNameProduct(),
            "descriptionProduct" => $this->getDescriptionProduct(),
            "quantityStorage" => $this->getQuantityStorage(),
            "priceProduct" => $this->getPriceProduct()
        ];

        $productManager = new Products();

        $productManager->saveDatasProducts($data_product);

    }

    public function listProducts()
    {
        $productsConfig = new Products();

        $datas = $productsConfig->getDatasProducts();

        if (empty($datas)) {
            return false;
        }

        return $datas;

    }

    public function getProductsById($id){
        $products = new Products();

        
    }



}