<?php

namespace mssimi\ContentManagementBundle\Controller;

use mssimi\ContentManagementBundle\Document\Block;
use mssimi\ContentManagementBundle\Form\BlockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Block controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/block")
 */
class BlockController extends Controller
{
    /**
     * Lists all Block entities.
     *
     * @Route("/index", name="_mssimi_block_index")
     * @Method("GET")
     * @return Response
     */
    public function indexAction()
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find('ContentManagementBundle:Block', '/cms/block');
        $blocks = $parent->getChildren();

        return $this->render('@ContentManagement/Block/index.html.twig', array(
            'blocks' => $blocks
        ));
    }

    /**
     * Lists all Block entities ajax.
     *
     * @Route("/search-index", name="_mssimi_block_search_index")
     * @param Request $request
     * @return Response
     * @Method({"GET","POST"})
     */
    public function indexSearchAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $blocks = $dm->getRepository('ContentManagementBundle:Block')->findLikeNodename($request->query->get('name'));

        return $this->render('@ContentManagement/Block/index.html.twig', array(
            'blocks' => $blocks
        ));
    }

    /**
     * Creates a new Block entity.
     *
     * @Route("/new", name="_mssimi_block_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find(null, '/cms/block');

        $block = new Block();
        $block->setParent($parent);
        $form = $this->createForm(BlockType::class, $block);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($block);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirectToRoute('_mssimi_block_index');
        }

        return $this->render('@ContentManagement/Block/persist.html.twig', array(
            'block' => $block,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Block entity.
     *
     * @Route("/edit/{id}", name="_mssimi_block_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $block = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(BlockType::class, $block);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($block);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirectToRoute('_mssimi_block_index');
        }

        return $this->render('@ContentManagement/Block/persist.html.twig', array(
            'block' => $block,
            'form' => $form->createView(),
        ));
    }

    /**
     * Route for inline edit using ajax
     *
     * @Route("/inline-edit/{id}", name="_mssimi_block_inline_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"POST"})
     * @param Request $request
     * @param Block $block
     * @return Response
     */
    public function inlineEditAction(Request $request, Block $block){

        $block->setContent($request->get('value'));
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->persist($block);
        $dm->flush();

        return new Response('success');
    }
}
