<?php

namespace mssimi\ContentManagementBundle\Form;

use mssimi\ContentManagementBundle\Document\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MenuType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'form.menu.name',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('label', null, array(
                'label' => 'form.menu.label',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('link', null, array(
                'label' => 'form.menu.link',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('targetBlank', null, array(
                'label' => 'form.menu.targetBlank',
                'attr' => array(
                    'class' => ''
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Menu::class
        ));
    }

    public function getName()
    {
        return 'content_management_bundle_menu_type';
    }
}
