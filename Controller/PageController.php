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
     * @return Response
     */
    public function indexAction()
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find('ContentManagementBundle:Page', '/cms/page');
        $pages = $parent->getChildren();

        return $this->render('@ContentManagement/Page/index.html.twig', array(
            'pages' => $pages
        ));
    }

    /**
     * Lists all Page entities ajax.
     *
     * @Route("/search-index", name="_mssimi_page_search_index")
     * @param Request $request
     * @return Response
     * @Method({"GET","POST"})
     */
    public function indexSearchAction(Request $request)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $pages = $dm->getRepository('ContentManagementBundle:Page')->findLikeNodename($request->query->get('name'));

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
            return $this->redirectToRoute('_mssimi_page_edit', array('id' => $page->getId()));
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
            return $this->redirectToRoute('_mssimi_page_edit', array('id' => $page->getId()));
        }

        return $this->render('@ContentManagement/Page/persist.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Route for inline edit using ajax
     *
     * @Route("/inline-edit/{id}", name="_mssimi_page_inline_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"POST"})
     * @param Request $request
     * @param Page $page
     * @return Response
     */
    public function inlineEditAction(Request $request, Page $page){

        $page->setContent($request->get('value'));
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->persist($page);
        $dm->flush();

        return new Response('success');
    }
}