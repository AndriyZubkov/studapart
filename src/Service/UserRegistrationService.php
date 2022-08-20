<?php

namespace App\Service;

use App\Entity\Forms\SignupForm;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * New users registration helping service
 */
class UserRegistrationService
{

    private EntityManagerInterface $em;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em             = $em;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Save new user to DB
     *
     * @param SignupForm $userData
     *
     * @return bool
     */
    public function addNewUserFromSignupForm(SignupForm $userData) : bool
    {
        $newUser = new User();

        $newUser->setEmail($userData->getEmail());
        $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $userData->getPassword()));
        $newUser->setPhone($userData->getPhone());
        $newUser->setRoles(['ROLE_USER']);

        $this->em->persist($newUser);
        try {
            $this->em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
