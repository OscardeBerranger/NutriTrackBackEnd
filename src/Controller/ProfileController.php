<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProfileController extends AbstractController
{

    #[Route('/api/whoami', name: 'whoami')]
    public function whoAmI(){
        return $this->json($this->getUser(), Response::HTTP_OK, [], ['groups' => ['user:read']]);
    }
    #[Route('/api/profile/edit/{id}', name: 'app_profile_edit')]
    public function edit(Profile $profile, SerializerInterface $serializer, Request $request, EntityManagerInterface $manager, GenderRepository $genderRepository): Response{
        if ($profile->getOfUser() !== $this->getUser()){
            return $this->json("You are not allowed to edit this profile", Response::HTTP_FORBIDDEN);
        }
        $tempProfile = $serializer->deserialize($request->getContent(), Profile::class, 'json', ['object_to_populate'=>$profile]);
        $genderId = $request->getPayload()->get('gender_id');
        if ($genderId){
            $gender = $genderRepository->findOneBy(["id"=>$genderId]);
            $tempProfile->setGender($gender);
        }
        $manager->flush();
        return $this->json($tempProfile, Response::HTTP_OK, [], ['groups' => 'profile:read']);
    }
}
