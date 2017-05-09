<?php

namespace mssimi\ContentManagementBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use mssimi\ContentManagementBundle\Document\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PageType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class PageType extends AbstractType
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
        ;
    }
    
    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Page::class
        ));
    }
}
