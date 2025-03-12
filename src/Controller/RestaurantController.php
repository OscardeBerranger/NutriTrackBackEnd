<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RestaurantController extends AbstractController
{

    #[Route('/api/restaurant/get/all', methods: ['GET'])]
    public function index(RestaurantRepository $restaurantRepository): Response{
        return $this->json($restaurantRepository->findAll(), Response::HTTP_OK, [], ['groups' => ['restaurant:read', 'address:read']]);
    }
    #[Route('/api/restaurant/create/{id}', name: 'app_restaurant_create', methods: ['POST'])]
    public function create(Address $address, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $restaurant = new Restaurant();
        $restaurant->setAddress($address);
        $entityManager->persist($restaurant);
        $entityManager->flush();
        return $this->json($restaurant, Response::HTTP_CREATED);
    }
}
