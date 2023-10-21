<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CustomerData;
use App\Http\Requests\CreateCostumerRequest;
use App\Http\Service\CostumerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostumerController extends Controller
{
    private $costumerService;

    public function __construct(CostumerService $costumerService)
    {
        $this->costumerService = $costumerService;
    }

    public function create(CreateCostumerRequest $request)
    {
        $costumer = new CustomerData(
            $request->input('nome'),
            $request->input('endereco'),
            $request->input('complemento'),
            $request->input('bairro'),
            $request->input('cep'),
            $request->input('email'),
            $request->input('telefone'),
            $request->input('data_nascimento')
        );

        $createdCostumer = $this->costumerService->addCostumer($costumer);

        return response($createdCostumer);
    }

    public function get(int $id)
    {
        $costumer = $this->costumerService->getById($id);

        return response($costumer);
    }

    public function list()
    {
        $costumers =  $this->costumerService->list();

        return response($costumers);
    }

    public function delete(int $id)
    {
        $this->costumerService->delete($id);

        return response(['message' => 'cliente excluido']);
    }
}
