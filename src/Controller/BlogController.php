<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\IsStoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/editorial", name="editorial")
     */
    public function show(ArticleRepository $articleRepo, IsStoryRepository $storyRepo)
    {
        $articles = $articleRepo->findBy(['isStory' => 0], ['listOrder'=> 'ASC']);
        $stories = $storyRepo->findAll();

        return $this->render('blog/editorial.html.twig', [
            'articles' => $articles,
            'stories' => $stories,
        ]);
    }
}
