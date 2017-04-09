<?php

namespace mssimi\ContentManagementBundle\Form;

use mssimi\ContentManagementBundle\Document\Directory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DirectoryType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class DirectoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'mssimiContentManagement.directory.form.name',
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
            'data_class' => Directory::class
        ));
    }
}
