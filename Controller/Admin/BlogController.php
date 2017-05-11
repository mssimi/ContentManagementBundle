<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\Blog;
use mssimi\ContentManagementBundle\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Blog controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * Lists all Blog entities.
     *
     * @Route("/index", name="mssimi_blog_index")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Blog')->pagination($request);

        $paginator  = $this->get('knp_paginator');
        $blogs = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.items_per_page')
        );

        return $this->render('@ContentManagement/Blog/index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    /**
     * Creates a new Blog entity.
     *
     * @Route("/new/{id}", name="mssimi_blog_new", defaults={"id" = "/cms/page"} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Blog $parent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, Blog $parent)
    {
        $blog = new Blog();
        $blog->setParent($parent);
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($blog);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_blog_index');
        }

        return $this->render('@ContentManagement/Blog/persist.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Blog entity.
     *
     * @Route("/edit/{id}", name="mssimi_blog_edit", options={"expose" = true} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $blog = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($blog);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_blog_index');
        }

        return $this->render('@ContentManagement/Blog/persist.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Blog entity.
     *
     * @Route("/remove/{id}", name="mssimi_blog_remove", options={"expose" = true} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param Blog $blog
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Blog $blog)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($blog);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_blog_index');
    }
}
