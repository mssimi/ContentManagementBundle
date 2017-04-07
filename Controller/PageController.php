<?php

namespace mssimi\ContentManagementBundle\Controller;

use mssimi\ContentManagementBundle\Document\Page;
use mssimi\ContentManagementBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Page controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/page")
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     *
     * @Route("/index", name="_mssimi_page_index")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Page')->pagination($request);

        $paginator  = $this->get('knp_paginator');
        $pages = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.items_per_page')
        );

        return $this->render('@ContentManagement/Page/index.html.twig', array(
            'pages' => $pages
        ));
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/new", name="_mssimi_page_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find(null, '/cms/page');

        $page = new Page();
        $page->setParent($parent);
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($page);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('_mssimi_page_index');
        }

        return $this->render('@ContentManagement/Page/persist.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/edit/{id}", name="_mssimi_page_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $page = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($page);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('_mssimi_page_index');
        }

        return $this->render('@ContentManagement/Page/persist.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Page entity.
     *
     * @Route("/remove/{id}", name="_mssimi_page_remove", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Page $page
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Page $page)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($page);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('_mssimi_page_index');
    }
}
