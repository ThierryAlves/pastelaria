<?php

namespace App\Http\Service;

use App\Models\Customer;

class CustomerService
{
    private $customerModel;

    public function __construct(Customer $customer)
    {
        $this->customerModel = $customer;
    }

    public function add(array $customerData) : Customer
    {
        return $this->customerModel->create($customerData);
    }

    public function getById(int $id) : Customer
    {
        return $this->customerModel->findOrFail($id);
    }

    public function list() : Customer
    {
        return $this->customerModel->simplePaginate(15);
    }

    public function update(Customer $customer, array $changedData) : Customer
    {
        $newCustomerData = array_merge($customer->toArray(), $changedData);
        $customer->update($newCustomerData);

        return $customer;
    }

    public function delete(Customer $customer) : void
    {
        $customer->delete();
    }
}
