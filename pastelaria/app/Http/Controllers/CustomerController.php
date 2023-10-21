<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CustomerData;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Service\CustomerService;

class CustomerController extends Controller
{
    private $customerService;
    private $customerData;

    public function __construct(CustomerService $customerService, CustomerData $customerData)
    {
        $this->customerService = $customerService;
        $this->customerData = $customerData;
    }

    public function create(CreateCustomerRequest $request)
    {
        $customer = $this->customerData->fromRequest($request);
        $createdCustomer = $this->customerService->add($customer);
        return response($createdCustomer);
    }

    public function get(int $id)
    {
        $customer = $this->customerService->getById($id);
        return response($customer);
    }

    public function list()
    {
        $customers =  $this->customerService->list();
        return response($customers);
    }

    public function update(UpdateCustomerRequest $request)
    {
        $customer = $this->customerData->fromRequest($request);
        $updatedCustomer =  $this->customerService->update($customer);
        return response($updatedCustomer);
    }

    public function delete(int $id)
    {
        $this->customerService->delete($id);
        return response(['message' => 'cliente excluido']);
    }

}
