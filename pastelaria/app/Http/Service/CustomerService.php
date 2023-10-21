<?php

namespace App\Http\Service;

use App\DataTransferObjects\CustomerData;
use App\Models\Customer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerService
{

    public function add(CustomerData $customer) : Customer
    {
        return Customer::create(
            $customer->toArray()
        );
    }

    public function getById(int $id) : Customer
    {
        $customer =  Customer::find($id);

        if (! $customer) {
            throw new NotFoundHttpException('Cliente não encontrado');
        }

        return $customer;
    }

    public function list()
    {
        return Customer::simplePaginate(1);
    }

    public function update(CustomerData $customer) : Customer
    {
        $customerFound = $this->getById($customer->id);
        $customerFound->update($customer->toArray());

        return $customerFound;
    }

    public function delete(int $id) : void
    {
        $customer = $this->getById($id);
        $customer->delete();
    }
}
