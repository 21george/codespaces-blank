<?php

namespace App\Models;

class User
{
    private $id;
    private $name;
    private $income;
    private $country;
    private $userType;

    public function __construct($name, $income, $country, $userType)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->income = $income;
        $this->country = $country;
        $this->userType = $userType;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getIncome()
    {
        return $this->income;
    }

    public function setIncome($income)
    {
        $this->income = $income;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    public function validate() {
        if (empty($this->name) || empty($this->country)) {
            throw new Exception("Name and country cannot be empty.");
        }
        if (!is_numeric($this->income) || $this->income < 0) {
            throw new Exception("Income must be a non-negative number.");
        }
    }
}