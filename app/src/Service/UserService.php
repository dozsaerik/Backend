<?php

namespace App\Service;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{

    public function __construct(
        private readonly TokenStorageInterface $tokenStorage
    )
    {
    }

    public function me(): array
    {
        $user = $this->tokenStorage->getToken()->getUser();

        return [
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ];

    }

}