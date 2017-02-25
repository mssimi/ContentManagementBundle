<?php

namespace mssimi\ContentManagementBundle\Twig;

use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class EditButtonTwigExtension
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class EditButtonTwigExtension extends Twig_Extension
{

    private $locales = array();

    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'edit_button_twig_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('edit_button_render', array($this, 'editButtonRender'), array('is_safe' => array('all'), 'needs_environment' => true)),
        );
    }

    /**
     * @param Twig_Environment $twig
     * @param $url
     * @param string $template
     * @return null|string
     * @internal param $path
     */
    public function editButtonRender(Twig_Environment $twig, $url , $template = 'ContentManagementBundle:Core:edit_button.html.twig')
    {
        return $twig->render($template, array('url' => $url, 'locales' => $this->locales));
    }
}
