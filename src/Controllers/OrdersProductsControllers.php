<?php

namespace Admin\Project\Controllers;



use Admin\Project\Models\OrdersProducts;

class OrdersProductsControllers
{
    private $idPedido;
    private $idProdutos;
    private $quantidade;

    /**
     * Get the value of quantidade
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     */
    public function setQuantidade($quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get the value of idProdutos
     */
    public function getIdProdutos()
    {
        return $this->idProdutos;
    }

    /**
     * Set the value of idProdutos
     */
    public function setIdProdutos($idProdutos): self
    {
        $this->idProdutos = $idProdutos;

        return $this;
    }

    /**
     * Get the value of idPedido
     */
    public function getIdPedido()
    {
        return $this->idPedido;
    }

    /**
     * Set the value of idPedido
     */
    public function setIdPedido($idPedido): self
    {
        $this->idPedido = $idPedido;

        return $this;
    }

    public function createOrdersProducts()
    {

        $data_orders_product = [
            "idPedido" => $this->getIdPedido(),
            "idProdutos" => $this->getIdProdutos(),
            "quantidade" => $this->getQuantidade()
        ];

        $ordersProductsManager = new OrdersProducts();
        $ordersProductsManager->saveDatasOrdersPorducts($data_orders_product);
    }

    public function listOrdersProducts()
    {
        $ordersProductsManager = new OrdersProducts();

        $datas = $ordersProductsManager->getDatasOrdersPorducts();

        if (empty($datas)) {
            return false;
        }

        return $datas;
    }

    public function getOrdersProductsById($id)
    {
        $ordersProductsManager = new OrdersProducts();

        $datas = $ordersProductsManager->getDatasOrdersProductsById($id);

        return $datas;
    }
}
