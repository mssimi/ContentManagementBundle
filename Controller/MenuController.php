<?php

namespace mssimi\ContentManagementBundle\Controller;

use mssimi\ContentManagementBundle\Document\Menu;
use mssimi\ContentManagementBundle\Form\MenuType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MenuController
 * @package mssimi\ContentManagementBundle\Controller
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/menu")
 */
class MenuController extends Controller
{
    /**
     * Lists all Menu entities.
     *
     * @Route("/index", name="mssimi_menu_index")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Menu')->pagination($request);

        $paginator  = $this->get('knp_paginator');
        $menus = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.items_per_page')
        );

        return $this->render('@ContentManagement/Menu/index.html.twig', array(
            'menus' => $menus
        ));
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/new/{id}", name="mssimi_menu_new", defaults={"id" = "/cms/menu"} , requirements={"id"="/cms/menu.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Menu $parent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, Menu $parent)
    {
        $menu = new Menu();
        $menu->setParent($parent);
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($menu);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_menu_index');
        }

        return $this->render('@ContentManagement/Menu/persist.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/edit/{id}", name="mssimi_menu_edit", options={"expose" = true} , requirements={"id"="/cms/menu.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $menu = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($menu);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_menu_index');
        }

        return $this->render('@ContentManagement/Menu/persist.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Menu entity.
     *
     * @Route("/remove/{id}", name="mssimi_menu_remove", options={"expose" = true} , requirements={"id"="/cms/menu.*"})
     * @Method({"GET", "POST"})
     * @param Menu $menu
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Menu $menu)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($menu);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_menu_index');
    }
}
