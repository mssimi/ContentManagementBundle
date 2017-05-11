<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\Slider;
use mssimi\ContentManagementBundle\Form\SliderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Slider controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/slider")
 */
class SliderController extends Controller
{
    /**
     * Lists all Slider entities.
     *
     * @Route("/index", name="mssimi_slider_index")
     * @Method("GET")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $query = $dm->getRepository('ContentManagementBundle:Slider')->pagination($request);

        $paginator  = $this->get('knp_paginator');
        $sliders = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('content_management.items_per_page')
        );

        return $this->render('@ContentManagement/Slider/index.html.twig', array(
            'sliders' => $sliders
        ));
    }

    /**
     * Creates a new Slider entity.
     *
     * @Route("/new/{id}", name="mssimi_slider_new", defaults={"id" = "/cms/slider"} , requirements={"id"="/cms/slider.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Slider $parent
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, Slider $parent)
    {
        $slider = new Slider();
        $slider->setParent($parent);
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($slider);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_slider_index');
        }

        return $this->render('@ContentManagement/Slider/persist.html.twig', array(
            'slider' => $slider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     * @Route("/edit/{id}", name="mssimi_slider_edit", options={"expose" = true} , requirements={"id"="/cms/slider.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $slider = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($slider);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_slider_index');
        }

        return $this->render('@ContentManagement/Slider/persist.html.twig', array(
            'slider' => $slider,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Slider entity.
     *
     * @Route("/remove/{id}", name="mssimi_slider_remove", options={"expose" = true} , requirements={"id"="/cms/slider.*"})
     * @Method({"GET", "POST"})
     * @param Slider $slider
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Slider $slider)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($slider);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_slider_index');
    }
}
