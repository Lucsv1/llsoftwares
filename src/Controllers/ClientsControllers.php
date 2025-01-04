<?php

class ClientsControllers
{
    private $db;

    private $nameClients;

    private $telephoneClients;

    private $cpfClients;

    private $cepClients;

    private $addressClients;

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

    
}
