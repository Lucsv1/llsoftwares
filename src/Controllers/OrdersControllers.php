<?php
namespace Admin\Project\Controllers;

use Admin\Project\Models\Orders;



class OrdersControllers
{
    private $idClient;

    private $price;

    public function getIdClient()
    {
        return $this->idClient;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }


    public function createOrders()
    {
        $data_orders = [
            'idClient' => $this->getIdClient(),
            'price' => $this->getPrice()
        ];

        $orderConfig = new Orders();

        $orderConfig->saveDatasOrders($data_orders);
    }


}