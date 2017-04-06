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
            new Twig_SimpleFunction('mssimi_menu_render', array($this, 'menuRender'), array('is_safe' => array('all'), 'needs_environment' => true)),
        );
    }

    /**
     * @param Twig_Environment $twig
     * @param $menu
     * @param string $template
     * @return null|string
     */
    public function menuRender(Twig_Environment $twig, $menu, $template = 'KnpMenuBundle::menu.html.twig')
    {
        return $twig->render('ContentManagementBundle:Menu:menu.html.twig', array('menu' => $menu, 'template' => $template));
    }
}
