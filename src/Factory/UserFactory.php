<?php

namespace App\Factory;

use App\Entity\User;
use App\Enum\RolesEnum;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as PasswordHasher;

class UserFactory
{
    public function __construct(
        private readonly PasswordHasher $passwordHasher,
    ) {}

    public function createUser(
        string $username,
        string $password,
        RolesEnum $role = RolesEnum::USER,
    ): User
    {
        $user = new User();

        $user->setUsername($username)
            ->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->setRoles([$role->value])
        ;

        return $user;
    }
}