<?php

namespace App\Controller;

use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_USER")]
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
    public function new(): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ArticleType::class);
        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route("/myarticle", name:"app_myarticle")]
    public function own(): Response
    {
        $user = $this->getUser();
        return $this->render('article/own.html.twig', [
            'user' => $user,
        ]);
    }
}

