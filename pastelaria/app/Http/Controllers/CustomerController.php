<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Service\CustomerService;
use App\Models\Customer;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    private CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function create(CreateCustomerRequest $request) : Response
    {
        $createdCustomer = $this->customerService->add($request->validated());
        return response($createdCustomer);
    }

    public function get(Customer $customer) : Response
    {
        return response($customer);
    }

    public function list() : Response
    {
        $customers = $this->customerService->list();
        return response($customers);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer) : Response
    {
        $updatedCustomer = $this->customerService->update($customer, $request->validated());
        return response($updatedCustomer);
    }

    public function delete(Customer $customer) : Response
    {
        $this->customerService->delete($customer);
        return response(['message' => 'cliente excluido']);
    }

}
