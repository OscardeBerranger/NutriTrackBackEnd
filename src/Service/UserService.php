<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isValid($email){
        return $this->userRepository->findOneBy(['email'=>$email]);
    }
}