<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as $data) {
            $user = (new User())
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setEmail($data['email'])
                ->setPlainPassword($data['plainPassword']);

            $password = $this->passwordEncoder->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getUserData(): array
    {
        return [
            [
                'email' => 'user1@atikla.com',
                'firstName' => 'First Name 1',
                'lastName' => 'Last Name1',
                'plainPassword' => '123456'
            ],
            [
                'email' => 'user2@atikla.com',
                'firstName' => 'First Name 2',
                'lastName' => 'Last Name2',
                'plainPassword' => '123456'
            ],
            [
                'email' => 'user3@atikla.com',
                'firstName' => 'First Name 3',
                'lastName' => 'Last Name3',
                'plainPassword' => '123456'
            ]
        ];
    }
}
