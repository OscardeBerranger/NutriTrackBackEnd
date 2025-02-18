<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NutriTrackController extends AbstractController
{
    #[Route('/nutri/track', name: 'app_nutri_track')]
    public function index(): Response
    {
        return $this->render('nutri_track/index.html.twig', [
            'controller_name' => 'NutriTrackController',
        ]);
    }
}
