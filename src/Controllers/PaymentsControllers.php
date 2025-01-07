<?php

namespace Admin\Project\Controllers;

use Admin\Project\Models\Payments;

class PaymentsControllers
{

    private $idOrder;

    private $method;


    public function getIdOrder()
    {
        return $this->idOrder;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setIdOrder($idOrder)
    {
        $this->idOrder = $idOrder;

        return $this;
    }

    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }


    public function createPayments(){

        $data_payment = [
            "idOrder" => $this->getIdOrder(),
            "method" => $this->getMethod()
        ];

        $paymentManager = new Payments();

        $paymentManager->saveDatasPayemnts($data_payment);

    }



}
