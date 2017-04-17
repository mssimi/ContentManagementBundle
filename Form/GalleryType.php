<?php

namespace mssimi\ContentManagementBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use mssimi\ContentManagementBundle\Document\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GalleryType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class GalleryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array_combine(
            array_map(function($key){ return 'mssimiContentManagement.page.form.template'.ucfirst($key); }, array_keys($options['templates'])),
            $options['templates']
        );

        $builder
            ->add('name', null, array(
                'label' => 'mssimiContentManagement.page.form.name',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('heading', null, array(
                'label' => 'mssimiContentManagement.page.form.heading',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('content', CKEditorType::class, array(
                'label' => 'mssimiContentManagement.page.form.content',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('metaKeywords', null, array(
                'label' => 'mssimiContentManagement.page.form.metaKeywords',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('metaDescription', null, array(
                'label' => 'mssimiContentManagement.page.form.metaDescription',
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
            ->add('template', ChoiceType::class, array(
                'label' => 'mssimiContentManagement.page.form.template',
                'choices' => $choices,
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('images', CollectionType::class, array(
                'entry_type' => GalleryImageType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'attr' => array(
                    'class' => 'image-collection row'
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
            'data_class' => Gallery::class
        ));

        $resolver->setRequired('templates');
    }
}
