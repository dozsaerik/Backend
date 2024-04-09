<?php

namespace App\Controller\Auth;

use App\DataObject\UserRegisterDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{

    #[NoReturn] #[Route(path: '/register', name: 'api_register', methods: ['POST'], format: 'json')]
    public function index(
        #[MapRequestPayload] UserRegisterDTO $userRegisterDTO,
        EntityManagerInterface               $entityManager,
        UserRepository                       $userRepository,
        UserPasswordHasherInterface          $hasher,
        ValidatorInterface                   $validator
    ): JsonResponse
    {


        $user = new User();
        $user->setEmail($userRegisterDTO->getEmail());
        $user->setPassword($hasher->hashPassword($user, $userRegisterDTO->getPassword()));

        $validation = $validator->validate($user);

        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->json([
                'message' => 'Az email cim már létezik.'
            ]);
        }


        return $this->json([
            'message' => 'Successfully registered.'
        ]);
    }

}