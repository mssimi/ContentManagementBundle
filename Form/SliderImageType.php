<?php

namespace mssimi\ContentManagementBundle\Form;

use mssimi\ContentManagementBundle\Document\SliderImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

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
            ->add('name', null, array(
                'label' => 'mssimiContentManagement.page.form.name',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('link', null, array(
                'label' => 'mssimiContentManagement.page.form.heading',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('publish', null, array(
                'label' => 'mssimiContentManagement.page.form.publish',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('imageFile', VichFileType::class, array(
                'label' => 'mssimiContentManagement.page.form.imageFile',
                'download_link' => false,
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
