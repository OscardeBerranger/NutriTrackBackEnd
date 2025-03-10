<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RestaurantController extends AbstractController
{
    #[Route('/api/restaurant/create', name: 'app_restaurant_create')]
    public function create(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }
}
