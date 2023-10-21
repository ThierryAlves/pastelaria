<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CustomerData;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Service\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function create(CreateCustomerRequest $request)
    {
        $customer = new CustomerData(
            $request->input('nome'),
            $request->input('endereco'),
            $request->input('complemento'),
            $request->input('bairro'),
            $request->input('cep'),
            $request->input('email'),
            $request->input('telefone'),
            $request->input('data_nascimento'),
            null
        );

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

    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = new CustomerData(
            $request->input('nome'),
            $request->input('endereco'),
            $request->input('complemento'),
            $request->input('bairro'),
            $request->input('cep'),
            $request->input('email'),
            $request->input('telefone'),
            $request->input('data_nascimento'),
            $id
        );

        $updatedCustomer =  $this->customerService->update($customer);

        return response($updatedCustomer);
    }

    public function delete(int $id)
    {
        $this->customerService->delete($id);

        return response(['message' => 'cliente excluido']);
    }

}
