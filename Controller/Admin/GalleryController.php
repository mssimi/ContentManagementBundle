<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\Gallery;
use mssimi\ContentManagementBundle\Form\GalleryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Gallery controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/gallery")
 */
class GalleryController extends Controller
{
    /**
     * Lists all Gallery entities.
     *
     * @Route("/index", name="mssimi_gallery_index")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Gallery')->pagination($request);

        $paginator  = $this->get('knp_paginator');
        $galleries = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.items_per_page')
        );

        return $this->render('@ContentManagement/Gallery/index.html.twig', array(
            'galleries' => $galleries
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     * @Route("/new/{id}", name="mssimi_gallery_new", defaults={"id" = "/cms/page"} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Gallery $parent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, Gallery $parent)
    {
        $gallery = new Gallery();
        $gallery->setParent($parent);
        $form = $this->createForm(GalleryType::class, $gallery, array('templates' => $this->getParameter('content_management.templates')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($gallery);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_gallery_index');
        }

        return $this->render('@ContentManagement/Gallery/persist.html.twig', array(
            'page' => $gallery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     * @Route("/edit/{id}", name="mssimi_gallery_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $gallery = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(GalleryType::class, $gallery, array('templates' => $this->getParameter('content_management.templates')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($gallery);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_gallery_index');
        }

        return $this->render('@ContentManagement/Gallery/persist.html.twig', array(
            'page' => $gallery,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Gallery entity.
     *
     * @Route("/remove/{id}", name="mssimi_gallery_remove", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Gallery $gallery
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Gallery $gallery)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($gallery);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_gallery_index');
    }
}
