<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{

    #[Route(path: '/api/register', name: 'api_register', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, UserPasswordHasherInterface $hasher): JsonResponse
    {

        $data = json_decode($request->getContent());
        $email = $data->email;
        $password = $data->password;

        if (!$email || !$password) {
            return $this->json([
                'error' => 'Null credentials'
            ]);
        }

        if ($userRepository->isEmailInUse($email)) {
            return $this->json([
                'error' => 'Email already in use'
            ]);
        }


        $user = new User();
        $user->setEmail($email);
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setRoles($user->getRoles());

        $entityManager->persist($user);
        $entityManager->flush();


        return $this->json([
            'Test' => 'Hello'
        ]);
    }

}