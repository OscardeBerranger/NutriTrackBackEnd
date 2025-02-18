<?php

namespace App\Controller;

use App\Service\NutriTrackService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/api/calories/required', name: 'app_required_calories')]
    public function getRequiredCalories(NutriTrackService $service): Response{
        $userProfile = $this->getUser()->getProfile();
        if (!$userProfile){
            return $this->json("Error profile not found", Response::HTTP_BAD_REQUEST);
        }
        $calories = $service->calcul_calories($userProfile->getGender()->getGender(), $userProfile->getWeight(), $userProfile->getHeight(), $userProfile->getAge(), $userProfile->getSportFrequecy());
        return $this->json($calories, Response::HTTP_OK);
    }


    #[Route('/api/calories/add', name: 'app_add_calories')]
    public function addCalories(Request $request, NutriTrackService $service, EntityManagerInterface $manager): Response{
        $calories = $request->getPayload()->get('calories');
        if ($calories <=0) {
            return $this->json("No calories", Response::HTTP_BAD_REQUEST);
        }
        $tracking = $this->getUser()->getProfile()->getTracking();
        $today = new \DateTime();
        $trackingDate = $tracking->getDate();
        if ($today->format("Y-m-d") != $trackingDate->format("Y-m-d")) {
            $tracking->setConsumedCalories(0);
        }
        $tracking->setConsumedCalories($tracking->getConsumedCalories() + $calories);
        $manager->flush();
        return $this->json($tracking->getConsumedCalories(), Response::HTTP_OK);
    }
}
