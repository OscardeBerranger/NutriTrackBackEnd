<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ProductRepository;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/api/order/place', methods: ['POST'])]
    public function placeOrder(Request $request, ProductRepository $productRepository, EntityManagerInterface $manager, OrderService $orderService): Response
    {
        $order = new Order();
        $items = $request->getPayload()->all('items');
        foreach($items as $item){
            $product = $productRepository->findOneBy(['id' => $item['id']]);
            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setQuantity($item['quantity']);
            $manager->persist($orderItem);
            $order->addOrderItem($orderItem);
        }
        $order->setOfProfile($this->getUser()->getProfile());
        $order->setStatus(0);
        $order->setTotal($orderService->getTotalOrder($order));
        $order->setAddress($request->getPayload()->get('address'));
        $manager->persist($order);
        $manager->flush();
        return $this->json($order, Response::HTTP_OK, [], ['groups' => 'order:read']);
    }




    #[Route('/api/order/pay/{id}', methods: ['POST'])]
    public function payOrder(Order $order, EntityManagerInterface $manager): Response
    {
        $order->setStatus(1);
        $manager->flush();
        return $this->json("Order id: ".$order->getId()." got paid..", Response::HTTP_OK, [], ['groups' => 'order:read']);
    }
}
