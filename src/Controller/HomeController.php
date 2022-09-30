<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $repoArticle;
    private $repoCategory;

    public function __construct(ArticleRepository $repoArticle, CategoryRepository $repoCategory)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        $articles = $this->repoArticle->findAll();
        $categories = $this->repoCategory->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories'=>$categories,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_show")
     */
    public function show(ArticleRepository $articleRepository, $id): Response
    { 
        $article = $articleRepository->findOneById($id);
        
        if(!$article){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('show/index.html.twig', [
            'article' => $article,
        ]);
    }


    
}
