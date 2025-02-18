<?php

namespace App\Controller;

use App\Entity\Gender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GenderController extends AbstractController
{
    #[Route('/gender', name: 'app_gender')]
    public function index(): Response
    {
        return $this->render('gender/index.html.twig', [
            'controller_name' => 'GenderController',
        ]);
    }

    #[Route('/gender/create', name: 'app_gender_create')]
    public function create(SerializerInterface $serializer, Request $request, EntityManagerInterface $manager): Response{
        $gender = $serializer->deserialize($request->getContent(), Gender::class, 'json');
        $manager->persist($gender);
        $manager->flush();
        return $this->json($gender, Response::HTTP_CREATED);
    }
}
