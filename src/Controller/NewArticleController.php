<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticleType;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewArticleController extends AbstractController
{
    /**
     * @Route("/new/article", name="new_article")
     * @param Articles|null $article
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function form(Articles $article = null, Request $request)
    {
        if ($article == null) {
            $article = new Articles();
        }
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$article->getSlug()) {
                $article->setCreatedAt(new \DateTime());
                $article->setUser($this->getUser());
            }

            $slugify = new Slugify();
            $article->setSlug($slugify->slugify($article->getTitle()));
            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('show', ['slug' => $article->getSlug()]);
        }

        return $this->render('new_article/index.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getSlug() !== null

        ]);
    }

}