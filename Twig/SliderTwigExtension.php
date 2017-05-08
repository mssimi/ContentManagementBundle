<?php

namespace mssimi\ContentManagementBundle\Twig;

use Doctrine\ODM\PHPCR\DocumentManager;
use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class SliderTwigExtension
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class SliderTwigExtension extends Twig_Extension
{

    /** @var DocumentManager */
    private $documentManager;

    private $profile;

    public function __construct(DocumentManagerInterface $documentManager)
    {
        $this->documentManager = $documentManager;
        $this->profile = array(
            'nodes' => array(),
            'status' => 'normal'
        );
    }

    /**
     * @return array
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'slider_twig_extension';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('slider_render', array($this, 'sliderRender'), array('is_safe' => array('all'), 'needs_environment' => true)),
        );
    }


    /**
     * @param Twig_Environment $twig
     * @param string $nodeName
     * @param $idSuffix
     * @param string $template
     * @return null|string
     */
    public function sliderRender(Twig_Environment $twig, $nodeName = '/', $idSuffix = null, $template = 'ContentManagementBundle:Slider:slider.html.twig')
    {
        $slider = $this->documentManager->find(null, $nodeName);

        $html = null;

        if($slider) {
            $html = $twig->render($template, array('slider' => $slider, 'idSuffix' => $idSuffix));
        }

        if($twig->isDebug()) {
            $this->updateProfile($html, $nodeName);
        }

        return $html;
    }

    /**
     * @param $html
     * @param $nodeName
     */
    private function updateProfile($html, $nodeName){
        if($html === null){
            $this->profile['status'] = 'yellow';
        }

        $this->profile['nodes'][] = array(
            'nodeName' => $nodeName,
            'status' => $html === null ? 'not found' : 'found'
        );
    }
}
