<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\Menu;
use mssimi\ContentManagementBundle\Document\MenuItem;
use mssimi\ContentManagementBundle\Form\MenuItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MenuItemController
 * @package mssimi\ContentManagementBundle\Controller
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/menu-item")
 */
class MenuItemController extends Controller
{
    /**
     * Lists all Menu item entities.
     *
     * @Route("/index/{id}", name="mssimi_menu_item_index", requirements={"id"="/cms/menu.*"})
     * @Method("GET")
     * @param Menu $menu
     * @return Response
     */
    public function indexAction(Menu $menu)
    {
        return $this->render('@ContentManagement/MenuItem/index.html.twig', array(
            'menu' => $menu
        ));
    }

    /**
     * Creates a new Menu item entity.
     *
     * @Route("/new/{id}", name="mssimi_menu_item_new", defaults={"id" = "/cms/menu"} , requirements={"id"="/cms/menu.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Menu $parent
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request, Menu $parent)
    {
        $menuItem = new MenuItem();
        $menuItem->setParent($parent);
        $form = $this->createForm(MenuItemType::class, $menuItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($menuItem);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_menu_item_index', array('id' => $menuItem->getMenuId()));
        }

        return $this->render('@ContentManagement/MenuItem/persist.html.twig', array(
            'menuItem' => $menuItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Menu item entity.
     *
     * @Route("/edit/{id}", name="mssimi_menu_item_edit", options={"expose" = true} , requirements={"id"="/cms/menu.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $menuItem = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(MenuItemType::class, $menuItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($menuItem);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_menu_item_index', array('id' => $menuItem->getMenuId()));
        }

        return $this->render('@ContentManagement/MenuItem/persist.html.twig', array(
            'menuItem' => $menuItem,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Menu item entity.
     *
     * @Route("/remove/{id}", name="mssimi_menu_item_remove", options={"expose" = true} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param MenuItem $menu
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(MenuItem $menu)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($menu);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_menu_index');
    }

    /**
     * reorder menu items
     *
     * @Route("/reorder", name="mssimi_menu_item_reorder", options={"expose" = true})
     * @Method({"POST"})
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reOrderAction(Request $request)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine_phpcr')->getManager();

        $child = $dm->find(null, $data['id']);
        $childName = $child->getName();
        $dm->move($child, $data['parent_id'] . '/' . $child->getName());
        $dm->flush();
        $dm->clear();

        $parent = $dm->find(null, $data['parent_id']);

        if(isset($data['before']) && $data['before']){
            $dm->reorder($parent, $childName, $data['before'], 0);
        }
        elseif(isset($data['after']) && $data['after']){
            $dm->reorder($parent, $childName, $data['after'], 1);
        }

        $dm->flush();

        return new Response();
    }

    /**
     * Search nodes ajax
     *
     * @Route("/ajax-index", name="mssimi_menu_item_ajax", options={"expose" = "true"})
     * @param Request $request
     * @return Response
     * @Method({"GET","POST"})
     */
    public function ajaxAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $menus = $dm->getRepository('ContentManagementBundle:AbstractPage')->findLikeNodename($request->request->get('query'), 20);

        $response = ['query' => 'Unit', 'suggestions' => []];

        foreach ($menus as $menu) {
            $response['suggestions'][] = ['value' => $menu->getId(), 'data' => $menu->getId()];
        }

        return $this->json($response);
    }
}
