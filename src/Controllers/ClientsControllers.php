<?php

namespace Admin\Project\Controllers;

use Admin\Project\Models\Clients;

class ClientsControllers
{

    private $nameClients;

    private $telephoneClients;

    private $cpfClients;

    private $cepClients;

    private $addressClients;

    private $emailClients;

    private $observation;

    /**
     * Get the value of nameClients
     */
    public function getNameClients()
    {
        return $this->nameClients;
    }

    /**
     * Set the value of nameClients
     *
     * @return  self
     */
    public function setNameClients($nameClients)
    {
        $this->nameClients = $nameClients;

        return $this;
    }

    /**
     * Get the value of telephoneClients
     */
    public function getTelephoneClients()
    {
        return $this->telephoneClients;
    }

    /**
     * Set the value of telephoneClients
     *
     * @return  self
     */
    public function setTelephoneClients($telephoneClients)
    {
        $this->telephoneClients = $telephoneClients;

        return $this;
    }

    /**
     * Get the value of cpfClients
     */
    public function getCpfClients()
    {
        return $this->cpfClients;
    }

    /**
     * Set the value of cpfClients
     *
     * @return  self
     */
    public function setCpfClients($cpfClients)
    {
        $this->cpfClients = $cpfClients;

        return $this;
    }

    /**
     * Get the value of cepClients
     */
    public function getCepClients()
    {
        return $this->cepClients;
    }

    /**
     * Set the value of cepClients
     *
     * @return  self
     */
    public function setCepClients($cepClients)
    {
        $this->cepClients = $cepClients;

        return $this;
    }

    /**
     * Get the value of addressClients
     */
    public function getAddressClients()
    {
        return $this->addressClients;
    }

    /**
     * Set the value of addressClients
     *
     * @return  self
     */
    public function setAddressClients($addressClients)
    {
        $this->addressClients = $addressClients;

        return $this;
    }

    /**
     * Get the value of emailClients
     */
    public function getEmailClients()
    {
        return $this->emailClients;
    }

    /**
     * Set the value of emailClients
     *
     * @return  self
     */
    public function setEmailClients($emailClients)
    {
        $this->emailClients = $emailClients;

        return $this;
    }

    /**
     * Get the value of observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set the value of observation
     */
    public function setObservation($observation): self
    {
        $this->observation = $observation;

        return $this;
    }


    public function createClient()
    {

        $data_clients = [
            'nameClient' => $this->getNameClients(),
            'telephoneClient' => $this->getTelephoneClients(),
            'cpfClients' => $this->getCpfClients(),
            'cepClients' => $this->getCepClients(),
            'addressClients' => $this->getAddressClients(),
            'emailClients' => $this->getEmailClients(),
            'observation' =>$this->getObservation()
        ];

        $clientsConfig = new Clients();

        $clientsConfig->saveDatasClients($data_clients);
    }

    public function listClients()
    {
        $clientsConfig = new Clients();

        $datas = $clientsConfig->getDatasClients();

        if (empty($datas)) {
            return false;
        }

        return $datas;
    }

    public function getClientsById($id)
    {   

        $clientsConfig = new Clients();

        $datas = $clientsConfig->getDatasClientsById($id);

        return $datas;

    }

    public function editClients($id)
    {

        $data_clients = [
            'nameClient' => $this->getNameClients(),
            'telephoneClient' => $this->getTelephoneClients(),
            'cpfClients' => $this->getCpfClients(),
            'cepClients' => $this->getCepClients(),
            'addressClients' => $this->getAddressClients(),
            'emailClients' => $this->getEmailClients()
        ];

        $clientsConfig = new Clients();

        $clientsConfig->editDatasClients($id, $data_clients);

    }

    public function deleteClients($id)
    {
        $clientsConfig = new Clients();

        $clientsConfig->delDatasClients($id);

    }


}