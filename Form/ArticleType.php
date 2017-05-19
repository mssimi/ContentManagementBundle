<?php

namespace mssimi\ContentManagementBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use mssimi\ContentManagementBundle\Document\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class ArticleType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'page.name',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('heading', null, array(
                'label' => 'page.heading',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('content', CKEditorType::class, array(
                'label' => 'page.content',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('metaKeywords', null, array(
                'label' => 'page.metaKeywords',
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
            ->add('imageFile', VichImageType::class, array(
                'label' => false,
                'download_link' => false,
                'allow_delete' => true,
                'required' => false,
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
            'data_class' => Article::class
        ));
    }
}
