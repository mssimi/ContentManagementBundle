<?php

namespace mssimi\ContentManagementBundle\Form;

use mssimi\ContentManagementBundle\Document\SliderImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class SliderImageType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class SliderImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('link', null, array(
                'label' => 'page.link',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('imageFile', VichImageType::class, array(
                'label' => 'page.imageFile',
                'download_link' => false,
                'allow_delete' => false,
                'required' => is_null($builder->getData()->getId()),
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('publish', null, array(
                'label' => 'page.publish',
                'attr' => array(
                    'class' => ''
                )
            ))
        ;
    }
    
    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SliderImage::class
        ));
    }
}
