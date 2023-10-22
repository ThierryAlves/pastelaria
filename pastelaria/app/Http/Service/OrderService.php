<?php

namespace App\Http\Service;

use App\Mail\OrderCreated;
use App\Models\ItensOrder;
use App\Models\Order;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    private $orderModel;
    private $itensOrderModel;

    public function __construct(Order $order, ItensOrder $itensOrder)
    {
        $this->orderModel = $order;
        $this->itensOrderModel = $itensOrder;
    }

    public function add(array $orderData) : Order
    {
        $orderCreated = $this->orderModel->create([
            'cliente_id' => $orderData['cliente_id']
        ]);

        foreach ($orderData['produtos'] as $product) {
            $this->itensOrderModel->create([
                'pedido_id' => $orderCreated->id,
                'produto_id' => $product
            ]);
        }

        $order = $this->getById($orderCreated->id);

        Mail::to("thierryalves.oliveira21@gmail.com")->send(new OrderCreated($order));

        return $order;
    }

    public function getById(int $id) : Order
    {
        return $this->orderModel
            ->with('items')
            ->with('items.product')
            ->with('customer')
            ->findOrFail($id);
    }

    public function list() : Paginator
    {
        return $this->orderModel
            ->with('items')
            ->with('items.product')
            ->simplePaginate(1);
    }

    public function changeProducts(Order $order) : Order
    {
        $this->itensOrderModel->where('pedido_id', $order->id)->delete();
    }

    public function delete(int $id) : void
    {
        $order = $this->getById($id);
        $order->delete();
    }
}
