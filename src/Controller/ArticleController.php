<?php

// src/Controller/ArticleController.php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route("/article", name:"article_")]
class ArticleController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    #[Route("/new", name:"new")]
    #[IsGranted("ROLE_USER")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Data is already set in the $article object
            // Retrieve form data
            $title = $form->get('title')->getData();
            $description = $form->get('description')->getData();
            $body = $form->get('body')->getData();

            try {
                $response = $this->client->request('POST', 'api/articles', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [ 
                    
                    'title' => $title,
                    'description' => $description,
                    'body' => $body]
                ]);

                if ($response->getStatusCode() === 200) {
                    return $this->redirectToRoute('app_index');
                } else {
                    dd('fuck u1');
                }
            } catch (\Throwable $e) {
                dd('fuck u2');
                // Handle exceptions
                // Log the error or display a message
            }
        }
        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
