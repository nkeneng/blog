<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comment;
use App\Entity\Comments;
use App\Form\CommentType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    /**
     * @Route("/home/{slug}", name="show")
     * @param Articles $article
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */

    public function index(Articles $article, Request $request)
    {
     $data = $article->getUser();
     dump($data);
        $comment = new Comments();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $comment->setCreatedAt(new DateTime());
            $comment->setAuthor($this->getUser());
            $comment->setArticle($article);
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('show', ['slug' => $article->getSlug()]);
        }

        return $this->render('show/index.html.twig', [
            'controller_name' => 'ShowController',
            'article' => $article,
            'formComment' => $formComment->createView(),
        ]);
    }
}
