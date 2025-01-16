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
            'price' => $this->getPrice(),
        ];

        $orderConfig = new Orders();

        $lastId = $orderConfig->saveDatasOrders($data_orders);

        return $lastId;
    }

    public function listOrders()
    {
        $orderConfig = new Orders();

        $datas = $orderConfig->getDatasOrders();

        if (empty($datas)) {
            return false;
        }

        return $datas;
    }

    public function getOrdersById($id)
    {
        $orderConfig = new Orders();

        $datas = $orderConfig->getDatasOrdersById($id);

        return $datas;
    }

    public function editOrders($id)
    {

        $orderConfig = new Orders();

        $data_orders = [
            'price' => $this->getPrice()
        ];

        $orderConfig->editDatasOrders($id, $data_orders);
    }


}
