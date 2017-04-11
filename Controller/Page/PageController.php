<?php

namespace mssimi\ContentManagementBundle\Controller\Page;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PageController extends Controller
{
    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("{id}", name="mssimi_page_render", options={"expose" = true} , requirements={"id"=".+"})
     * @Method({"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function pageAction($id)
    {
        $dm = $this->get('doctrine_phpcr')->getManager();
        $page = $dm->find(null, '/cms/page/' . $id);

        if(!$page || !$page->getPublish()){
            throw $this->createNotFoundException();
        }

        return $this->render('@ContentManagement/Page/page.html.twig', array(
            'page' => $page,
        ));
    }
}
