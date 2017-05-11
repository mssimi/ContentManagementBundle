<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\SliderImage;
use mssimi\ContentManagementBundle\Document\Slider;
use mssimi\ContentManagementBundle\Form\SliderImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * SliderImage controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/sliderImage")
 */
class SliderImageController extends Controller
{
    /**
     * Lists all SliderImage entities.
     *
     * @Route("/index/{id}", name="mssimi_slider_image_index", requirements={"id"="/cms/slider.*"})
     * @Method("GET")
     * @param Slider $slider
     * @return Response
     */
    public function indexAction(Slider $slider)
    {
        return $this->render('@ContentManagement/SliderImage/index.html.twig', array(
            'slider' => $slider
        ));
    }

    /**
     * Creates a new SliderImage entity.
     *
     * @Route("/new/{id}", name="mssimi_slider_image_new", defaults={"id" = "/cms/slider"} , requirements={"id"="/cms/slider.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Slider $slider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, Slider $slider)
    {
        $sliderImage = new SliderImage();
        $sliderImage->setParent($slider);
        $form = $this->createForm(SliderImageType::class, $sliderImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($sliderImage);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('mssimi_slider_image_index', array('id' => $slider->getId()));
        }

        return $this->render('@ContentManagement/SliderImage/persist.html.twig', array(
            'sliderImage' => $sliderImage,
            'slider' => $slider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SliderImage entity.
     *
     * @Route("/edit/{id}", name="mssimi_slider_image_edit", options={"expose" = true} , requirements={"id"="/cms/slider.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $sliderImage = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(SliderImageType::class, $sliderImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($sliderImage);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('mssimi_slider_image_index', array('id' => $sliderImage->getParent()->getId()));
        }

        return $this->render('@ContentManagement/SliderImage/persist.html.twig', array(
            'sliderImage' => $sliderImage,
            'slider' => $sliderImage->getParent(),
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing SliderImage entity.
     *
     * @Route("/remove/{id}", name="mssimi_slider_image_remove", options={"expose" = true} , requirements={"id"="/cms/page.*"})
     * @Method({"GET", "POST"})
     * @param SliderImage $sliderImage
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(SliderImage $sliderImage)
    {
        $slider = $sliderImage->getParent();
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($sliderImage);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirectToRoute('mssimi_slider_image_index', array('id' => $slider->getId()));
    }

    /**
     * reorder an existing slider images entity.
     *
     * @Route("/reorder", name="mssimi_slider_image_reorder", options={"expose" = true})
     * @Method({"POST"})
     * @param Request $request
     * @return Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reOrderAction(Request $request)
    {
        $data = $request->request->all();
        $dm = $this->get('doctrine_phpcr')->getManager();

        $child = $dm->find(null, $data['id']);
        $parent = $dm->find(null, $data['parent_id']);

        if(isset($data['before']) && $data['before']){
            $dm->reorder($parent, $child->getName(), $data['before'], 0);
        }
        elseif(isset($data['after']) && $data['after']){
            $dm->reorder($parent, $child->getName(), $data['after'], 1);
        }

        $dm->flush();

        return new Response();
    }
}
