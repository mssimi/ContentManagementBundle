<?php

namespace mssimi\ContentManagementBundle\Form;

use mssimi\ContentManagementBundle\Document\GalleryImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class GalleryImageType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class GalleryImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, array(
                'label' => false,
                'download_link' => false,
                'allow_delete' => false,
                'required' => false,
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('title', null, array(
                'label' => false,
                'attr' => array(
                    'class' => 'input-sm',
                    'placeholder' => 'mssimiContentManagement.galleryImage.form.title',
                )
            ))
            ->add('perex', null, array(
                'label' => false,
                'attr' => array(
                    'class' => 'input-sm',
                    'placeholder' => 'mssimiContentManagement.galleryImage.form.perex',
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
            'data_class' => GalleryImage::class
        ));
    }
}
