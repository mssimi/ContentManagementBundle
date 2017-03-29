<?php

namespace mssimi\ContentManagementBundle\Twig;

use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class MenuTwigExtension
 * @package mssimi\ContentManagementBundle\Twig
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class MenuTwigExtension extends Twig_Extension
{

    /** @var DocumentManager */
    private $documentManager;

    public function __construct(DocumentManagerInterface $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'menu_twig_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('menu_render', array($this, 'menuRender'), array('is_safe' => array('all'), 'needs_environment' => true)),
        );
    }

    /**
     * @param Twig_Environment $twig
     * @param string $nodeName
     * @param $idSuffix
     * @param string $template
     * @return null|string
     */
    public function menuRender(Twig_Environment $twig, $nodeName = '/', $idSuffix = null, $template = 'ContentManagementBundle:Menu:menu.html.twig')
    {
        $menu = $this->documentManager->find(null, $nodeName);

        $html = null;

        if($menu) {
            $html = $twig->render($template, array('menu' => $menu, 'idSuffix' => $idSuffix));
        }


        return $html;
    }
}
