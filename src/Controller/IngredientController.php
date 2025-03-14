<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Product;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class IngredientController extends AbstractController
{
    #[Route('/api/ingredient/create', name: 'app_ingredient_create', methods: ['POST'])]
    public function create(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager): Response
    {
        $ingredient = $serializer->deserialize($request->getContent(), Ingredient::class, 'json');
        $manager->persist($ingredient);
        $manager->flush();
        return $this->json($ingredient, Response::HTTP_CREATED);
    }


    #[Route('/api/ingredient/edit/{id}', name: 'app_ingredient_edit', methods: ['POST'])]
    public function edit(Ingredient $ingredient, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager): Response{
        $serializer->deserialize($request->getContent(), Ingredient::class, 'json', ['object_to_populate'=>$ingredient]);
        $manager->flush();
        return $this->json($ingredient, Response::HTTP_OK, [], ['groups' => 'product:read']);
    }
}
