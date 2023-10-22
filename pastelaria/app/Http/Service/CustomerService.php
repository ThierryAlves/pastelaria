<?php

namespace App\Http\Service;

use App\Models\Customer;
use Illuminate\Pagination\Paginator;

class CustomerService
{
    private Customer $customerModel;

    public function __construct(Customer $customer)
    {
        $this->customerModel = $customer;
    }

    public function add(array $customerData) : Customer
    {
        return $this->customerModel->create($customerData);
    }

    public function list() : Paginator
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
