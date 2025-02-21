<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\TaxService;

class UserController
{
    private $users = [];
    private $taxService;

    public function __construct()
    {
        $this->taxService = new TaxService();
    }

    public function createUser($data)
    {
        $user = new User($data['name'], $data['income'], $data['country'], $data['userType']);
        $this->users[$user->getId()] = $user;
        return $user;
    }

    public function readUser($id)
    {
        return isset($this->users[$id]) ? $this->users[$id] : null;
    }

    public function updateUser($id, $data)
    {
        if (isset($this->users[$id])) {
            $this->users[$id]->setName($data['name']);
            $this->users[$id]->setIncome($data['income']);
            $this->users[$id]->setCountry($data['country']);
            $this->users[$id]->setUserType($data['userType']);
            return $this->users[$id];
        }
        return null;
    }

    public function deleteUser($id)
    {
        if (isset($this->users[$id])) {
            unset($this->users[$id]);
            return true;
        }
        return false;
    }

    public function calculateTotalIncome()
    {
        $totalIncome = 0;
        foreach ($this->users as $user) {
            $totalIncome += $user->getIncome();
        }
        return $totalIncome;
    }

    public function processTaxRefunds()
    {
        $refunds = [];
        foreach ($this->users as $user) {
            $refunds[$user->getId()] = $this->taxService->calculateRefund($user->getIncome(), $user->getCountry());
        }
        return $refunds;
    }

    public function uploadReceipt($request)
    {
        $userId = $request['userId'];
        $receipt = $request['receipt'];

        try {
            $receiptId = $this->taxService->uploadReceipt($receipt, $userId);
            return ['status' => 'success', 'receiptId' => $receiptId];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function isPrivateUser($userId)
    {
        $user = $this->readUser($userId);
        return $user && $user->getUserType() === 'private';
    }

    public function isCompanyUser($userId)
    {
        $user = $this->readUser($userId);
        return $user && $user->getUserType() === 'company';
    }

    public function getNecessaryDocumentsForPrivateUser($userId)
    {
        if (!$this->isPrivateUser($userId)) {
            throw new Exception("User is not a private user");
        }

        // Logic to get necessary documents for private user
        return [
            'ID Proof',
            'Income Proof',
            'Address Proof'
        ];
    }

    public function getNecessaryDocumentsForCompanyUser($userId)
    {
        if (!$this->isCompanyUser($userId)) {
            throw new Exception("User is not a company user");
        }

        // Logic to get necessary documents for company user
        return [
            'Company Registration Certificate',
            'Tax Identification Number',
            'Financial Statements'
        ];
    }
}