<?php

namespace mssimi\ContentManagementBundle\Controller\Admin;

use mssimi\ContentManagementBundle\Document\Directory;
use mssimi\ContentManagementBundle\Form\DirectoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Directory controller.
 * @author Marek Šimeček <mssimi@seznam.cz>
 * @Route("/directory")
 */
class DirectoryController extends Controller
{
    /**
     * Creates a new Directory entity.
     *
     * @Route("/new/{id}", name="mssimi_directory_new", requirements={"id"="/cms.*"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $parent = $dm->find(null, $id);

        $directory = new Directory();
        $directory->setParent($parent);
        $form = $this->createForm(DirectoryType::class, $directory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dm = $this->get('doctrine_phpcr')->getManager();
            $dm->persist($directory);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityCreated');
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('@ContentManagement/Directory/persist.html.twig', array(
            'directory' => $directory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Directory entity.
     *
     * @Route("/edit/{id}", name="mssimi_directory_edit", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $directory = $dm->findTranslation(null, $id, $request->query->get('locale'));
        $form = $this->createForm(DirectoryType::class, $directory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $dm->persist($directory);
            $dm->flush();

            $this->addFlash('success', 'flashMessage.common.entityUpdated');
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('@ContentManagement/Directory/persist.html.twig', array(
            'directory' => $directory,
            'form' => $form->createView(),
        ));
    }

    /**
     * remove an existing Directory entity.
     *
     * @Route("/remove/{id}", name="mssimi_directory_remove", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Directory $directory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function removeAction(Request $request, Directory $directory)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $dm->remove($directory);
        $dm->flush();

        $this->addFlash('success', 'fleshMessage.common.entityRemoved');
        return $this->redirect($request->headers->get('referer'));
    }
}
