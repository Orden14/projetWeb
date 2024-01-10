<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly UserRepository $userRepository
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            if ($user !== null) {
                for ($i = 0; $i < 3; $i++) {
                    $manager->persist($this->generateArticle($faker, $user));
                }
            }
            $manager->flush();
        }
    }

    private function generateArticle(Generator $faker, User $author): Article
    {
        $article = new Article();

        $title = $faker->sentence();
        $slug = $this->slugger->slug($title)->lower();

        $article->setTitle($title)
            ->setSlug($slug)
            ->setDescription($faker->text())
            ->setUser($author)
            ->setCreatedAt(new DateTimeImmutable())
            ->setPublishedAt(new DateTimeImmutable())
        ;

        return $article;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}