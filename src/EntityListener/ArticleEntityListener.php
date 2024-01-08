<?php

namespace App\EntityListener;

use App\Entity\User;
use App\Entity\Article;
use Doctrine\ORM\Events;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Article::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Article::class)]
class ArticleEntityListener
{
    public function __construct(
        private SluggerInterface $slugger,
        private Security $security
    ) {}

    public function prePersist(Article $article, LifecycleEventArgs $event): void
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        $article->computeSlug($this->slugger);
        $article->setUser($currentUser);
    }

    public function preUpdate(Article $article, LifecycleEventArgs $event): void
    {
        $article->computeSlug($this->slugger);
    }
}