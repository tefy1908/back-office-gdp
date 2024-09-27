<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créons 10 utilisateurs fictifs
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@example.com");

            // Hacher le mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'password123'
            );
            $user->setPassword($hashedPassword);

            // Ajouter un rôle basique
            $user->setRoles(['ROLE_USER']);

            // Persister l'utilisateur
            $manager->persist($user);
        }

        // Sauvegarder tous les utilisateurs dans la base de données
        $manager->flush();
    }
}
