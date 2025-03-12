<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderService
{
    private OrderRepository $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getTotalOrder(Order $order)
    {
        $items = $order->getOrderItems();
        $total = 0.0;
        foreach ($items as $item) {
            $price = $item->getProduct()->getPrice();
            $quatity = $item->getQuantity();
            $total += $price * $quatity;
        }
        return $total;
    }
}