<?php

namespace App\Controller;

use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $user = $this->getUser();
        return $this->render('article/index.html.twig', [
            'user' => $user,
        ]);
    }
    
    #[Route("/new", name:"article_new")]
    #[IsGranted("ROLE_USER")]
    public function new(): Response
    {
        $form = $this->createForm(ArticleType::class);
        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
