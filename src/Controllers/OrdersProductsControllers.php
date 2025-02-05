<?php

namespace Admin\Project\Controllers;



use Admin\Project\Models\OrdersProducts;

class OrdersProductsControllers
{
    private $idPedido;
    private $idProdutos;
    private $quantidade;
    private $valorUnitario;
    private $valorTotal;

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

    /**
     * Get the value of valorTotal
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set the value of valorTotal
     *
     * @return  self
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    public function createOrdersProducts()
    {

        $data_orders_product = [
            "idPedido" => $this->getIdPedido(),
            "idProdutos" => $this->getIdProdutos(),
            "quantidade" => $this->getQuantidade(),
            "valorUnitario" => $this->getValorUnitario(),
            "valorTotal" => $this->getValorTotal()
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
