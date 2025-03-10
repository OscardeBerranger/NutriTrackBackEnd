<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Restaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddressController extends AbstractController
{
    #[Route('/api/address/create', name: 'app_address_create', methods: ['POST'])]
    public function create(EntityManagerInterface $manager, SerializerInterface $serializer, Request $request): Response
    {
        $address = $serializer->deserialize($request->getContent(), Address::class, 'json');
        $manager->persist($address);
        $manager->flush();
        return $this->json($address, Response::HTTP_CREATED, [], ['groups' => ["address:read"]]);
    }

    #[Route('/api/address/link/profile/{id}', name: 'app_address_link_profile', methods: ['GET', 'POST'])]
    public function linkToProfile(Address $address, EntityManagerInterface $manager): Response{
        $profile = $this->getUser()->getProfile();
        $profile->addAddress($address);
        $manager->flush();
        return $this->json($profile, Response::HTTP_OK, [], ['groups' => ["profile:read", "address:read"]]);
    }

    #[Route('/api/address/link/restaurant/{addressId}/{restaurantId}', name: 'app_address_link_restaurant', methods: ['GET', 'POST'])]
    public function linkToRestaurant(
        #[MapEntity(mapping: ['addressId'=>'id'])]Address $address,
        #[MapEntity(mapping: ['restaurantId'=>'id'])]Restaurant $restaurant,
        EntityManagerInterface $manager): Response{
        $restaurant->setAddress($address);
        $manager->flush();
        return $this->json($restaurant, Response::HTTP_OK);
    }
}
