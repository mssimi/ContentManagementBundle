<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\Article;
use mssimi\ContentManagementBundle\Document\Blog;
use mssimi\ContentManagementBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Article controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     * @Route("/index", name="mssimi_article_index")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Article')->pagination($request);

        $paginator  = $this->get('knp_paginator');
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.items_per_page')
        );

        return $this->render('@ContentManagement/Article/index.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/new/{id}", name="mssimi_article_new", defaults={"id" = "/cms/page"} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Blog $parent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, Blog $parent)
    {
        $article = new Article();
        $article->setParent($parent);
        $form = $this->createForm(ArticleType::class, $article, array('templates' => $this->getParameter('content_management.templates')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($article);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_article_index');
        }

        return $this->render('@ContentManagement/Article/persist.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/edit/{id}", name="mssimi_article_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $article = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(ArticleType::class, $article, array('templates' => $this->getParameter('content_management.templates')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($article);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_article_index');
        }

        return $this->render('@ContentManagement/Article/persist.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Article entity.
     *
     * @Route("/remove/{id}", name="mssimi_article_remove", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Article $article
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Article $article)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($article);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_article_index');
    }
}
