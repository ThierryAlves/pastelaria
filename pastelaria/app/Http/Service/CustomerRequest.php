<?php

namespace App\Http\Service;

use App\DataTransferObjects\CustomerData;
use App\Models\Costumer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CostumerService
{

    public function addCostumer(CustomerData $costumer) : Costumer
    {
        return Costumer::create(
            $costumer->toArray()
        );
    }

    public function getById(int $id) : Costumer
    {
        $costumer =  Costumer::find($id);

        if (! $costumer) {
            throw new NotFoundHttpException('Cliente não encontrado');
        }

        return $costumer;
    }

    public function list()
    {
        return Costumer::simplePaginate(1);
    }

    public function delete(int $id) : void
    {
        $costumer = $this->getById($id);
        $costumer->delete();
    }
}
