<?php

namespace mssimi\ContentManagementBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use mssimi\ContentManagementBundle\Document\Page;
use Symfony\Component\Form\AbstractType;
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
                'label' => 'form.page.name',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('heading', null, array(
                'label' => 'form.page.heading',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('content', CKEditorType::class, array(
                'label' => 'form.page.content',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('metaKeywords', null, array(
                'label' => 'form.page.metaKeywords',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('metaDescription', null, array(
                'label' => 'form.page.metaDescription',
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
