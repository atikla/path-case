<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\Validation\ValidationException;
use App\Service\Validation\ValidationService;
use App\Traits\EntityManagerAwareTrait;
use \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterService
{
    use EntityManagerAwareTrait;

    /**
     * @var ValidationService $validationService
     */
    private ValidationService $validationService;

    /**
     * @var User $user
     */
    private User $user;

    /**
     * @var UserPasswordHasherInterface $passwordEncoder
     */
    private UserPasswordHasherInterface $passwordEncoder;

    /**
     * @param ValidationService $validationService
     * @param UserPasswordHasherInterface $passwordEncoder
     */
    public function __construct(ValidationService $validationService, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->validationService = $validationService;
        $this->user = new User();
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param array $requestBody
     * @return UserRegisterService
     * @throws ValidationException
     */
    public function validate(array $requestBody): self
    {
        $this->user
            ->setFirstName($requestBody['firstName'])
            ->setLastName(($requestBody['lastName']))
            ->setEmail($requestBody['email'])
            ->setPlainPassword($requestBody['password']);

        $this->validationService->validate($this->user);

        return $this;
    }

    /**
     * @return User
     */
    public function register(): User
    {
        $password = $this->passwordEncoder->hashPassword($this->user, $this->user->getPlainPassword());
        $this->user->setPassword($password);
        $this->getEntityManager()->persist($this->user);
        $this->getEntityManager()->flush($this->user);

        return $this->user;
    }
}
