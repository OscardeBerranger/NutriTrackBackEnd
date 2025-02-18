<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Tracking;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\GenderRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'api_register')]
    public function register(GenderRepository $genderRepository, Request $request,SerializerInterface $serializer,UserService $service , EntityManagerInterface $manager , UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');


        if (!$service->isValid($user->getEmail())){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
            $profile = $serializer->deserialize($request->getContent(), Profile::class, 'json');
            $genderId = $request->getPayload()->get("gender_id");
            $gender = $genderRepository->findOneBy(['id' => $genderId]);
            $profile->setGender($gender);
            $user->setProfile($profile);
            $manager->persist($user);
            $currentDate = new \DateTimeImmutable();
            $profile->setCreatedAt($currentDate);
            $manager->persist($profile);
            $tracking = new Tracking();
            $tracking->setConsumedCalories(0);
            $tracking->setDate($currentDate);
            $tracking->setOfProfile($profile);
            $manager->persist($tracking);
            $manager->flush();

            return $this->json($user, 200,[], ['groups'=>'user:read']);
        }
        return $this->json('User already exist !', 400);
    }

    #[Route('/app/register', name: 'app_register')]
    public function appRegister(GenderRepository $genderRepository, Request $request,SerializerInterface $serializer,UserService $service , EntityManagerInterface $manager , UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
