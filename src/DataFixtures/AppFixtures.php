<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'admin');

        $user->setUsername('admin');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);

        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();

            $title = "Article $i";
            $slug = $this->slugger->slug($title)->lower();

            $article->setTitle($title);
            $article->setSlug($slug);
            $article->setDescription("Description $i");
            $article->setUser($user);
            $article->setCreatedAt(new DateTimeImmutable());
            $article->setPublishedAt(new DateTimeImmutable());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
