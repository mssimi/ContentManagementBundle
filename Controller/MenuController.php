<?php

namespace mssimi\ContentManagementBundle\Controller;

use mssimi\ContentManagementBundle\Document\Menu;
use mssimi\ContentManagementBundle\Form\MenuType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/index", name="_mssimi_menu_index")
     * @Method("GET")
     * @return Response
     */
    public function indexAction()
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find('ContentManagementBundle:Menu', '/cms/menu');
        $menus = $parent->getChildren();

        return $this->render('@ContentManagement/Menu/index.html.twig', array(
            'menus' => $menus
        ));
    }

    /**
     * Lists all Menu entities ajax.
     *
     * @Route("/search-index", name="_mssimi_menu_search_index")
     * @param Request $request
     * @return Response
     * @Method({"GET","POST"})
     */
    public function indexSearchAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $menus = $dm->getRepository('ContentManagementBundle:Menu')->findLikeNodename($request->query->get('name'));

        return $this->render('@ContentManagement/Menu/index.html.twig', array(
            'menus' => $menus
        ));
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/new", name="_mssimi_menu_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find(null, '/cms/menu');

        $menu = new Menu();
        $menu->setParent($parent);
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($menu);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('_mssimi_menu_edit', array('id' => $menu->getId()));
        }

        return $this->render('@ContentManagement/Menu/persist.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/edit/{id}", name="_mssimi_menu_edit", options={"expose" = true} , requirements={"id"=".+"})
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
            return $this->redirectToRoute('_mssimi_menu_edit', array('id' => $menu->getId()));
        }

        return $this->render('@ContentManagement/Menu/persist.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
        ));
    }
}
