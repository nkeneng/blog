<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\ArticlesSearch;
use App\Form\ArticlesSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search = new ArticlesSearch();
        $form = $this->createForm(ArticlesSearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form["category"]->getData();
            $list = $paginator->paginate($this->getDoctrine()->getRepository(Articles::class)->findByCategory($data), $request->query->getInt('page', 1), 4);
        } else
            $list = $paginator->paginate($this->getDoctrine()->getRepository(Articles::class)->findAll(), $request->query->getInt('page', 1), 4);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'paginator' => $list,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="category")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchByCategory($id,PaginatorInterface $paginator,Request $request)
    {
        $article = $paginator->paginate($this->getDoctrine()->getRepository(Articles::class)->findBy(['category' => $id]),$request->query->getInt('page', 1), 4);

//        $article = $this->getDoctrine()->getRepository(Articles::class)->findBy(['category' => $id]);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'CategoryController',
            'paginator' => $article,
        ]);
    }
}
