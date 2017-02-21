<?php

namespace mssimi\ContentManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ContentManagementBundle:Default:index.html.twig');
    }
}
