<?php

namespace mssimi\ContentManagementBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use mssimi\ContentManagementBundle\Document\Block;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BlockType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class BlockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'mssimiContentManagement.block.form.name',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('content', CKEditorType::class, array(
                'label' => 'mssimiContentManagement.block.form.content',
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
            'data_class' => Block::class
        ));
    }
}
