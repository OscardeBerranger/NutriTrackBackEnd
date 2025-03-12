<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Product;
use App\Entity\Restaurant;
use App\Repository\IngredientRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{

    #[Route('/api/product/all', name: 'app_product_get_all', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->json($productRepository->findAll(), Response::HTTP_OK, [], ["groups" => ["product:read"]]);
    }
    #[Route('/api/product/get/{id}', name: 'app_product_get', methods: ['GET'])]
    public function get(Product $product): Response{
        return $this->json($product, Response::HTTP_OK, [], ['groups' => 'product:read']);
    }

    #[Route('/api/product/create/{id}', name: 'app_product_create', methods: ['POST'])]
    public function create(Request $request,Restaurant $restaurant, SerializerInterface $serializer, IngredientRepository $ingredientRepository, EntityManagerInterface $manager): Response
    {
        /**
         * A METTRE LORSQU'IL Y AURA OWNER
        */
//        if ($this->getUser() !== $restaurant->getOwner()){
//            return $this->json(null, Response::HTTP_FORBIDDEN);
//        }
        $product = $serializer->deserialize($request->getContent(), Product::class, 'json');
        $product->setRestaurant($restaurant);
        $ingredients_ids = $request->getPayload()->all('ingredients_ids');
        foreach ($ingredients_ids as $id) {
            $ingredient = $ingredientRepository->findOneBy(["id" => $id]);
            if ($ingredient) {
                $product->addIngredient($ingredient);
            }
        }
        $manager->persist($product);
        $manager->flush();
        return $this->json($product, Response::HTTP_CREATED, [], ["groups"=>"product:read", "address:read"]);
    }

    #[Route('/api/product/edit/{id}', name: 'app_product_edit', methods: ['POST'])]
    public function edit(Product $product, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, IngredientRepository $ingredientRepository): Response{
        $serializer->deserialize($request->getContent(), Product::class, 'json', ['object_to_populate'=>$product]);

        $ingredients_ids = $request->getPayload()->all('ingredients_ids');
        foreach ($ingredients_ids as $id) {
            $ingredient = $ingredientRepository->findOneBy(["id" => $id]);
            if ($ingredient) {
                $product->addIngredient($ingredient);
            }
        }
        $manager->flush();
        return $this->json($product, Response::HTTP_ACCEPTED, [], ["groups"=>"product:read"]);
    }

    #[Route('/api/product/removeIngredient/{product_id}/{ingredient_id}', name: 'app_product_remove_ingredient', methods: ['DELETE'])]
    public function removeIngredien(EntityManagerInterface $manager,
    #[MapEntity(mapping: ['product_id'=>'id'])]Product $product,
    #[MapEntity(mapping: ['ingredient_id'=>'id'])]Ingredient $ingredient): Response{
        $product->removeIngredient($ingredient);
        $manager->flush();
        return $this->json($product, Response::HTTP_OK, [], ['groups' => 'product:read']);
    }

    #[Route('/api/product/delete/{id}', name: 'app_product_delete', methods: ['DELETE'])]
    public function delete(Product $product, SerializerInterface $serializer, EntityManagerInterface $manager): Response{
        $manager->remove($product);
        $manager->flush();
        return $this->json("Product removed", Response::HTTP_OK);
    }
}
