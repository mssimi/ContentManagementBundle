<?php

namespace mssimi\ContentManagementBundle\Form;

use mssimi\ContentManagementBundle\Document\MenuItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class MenuType
 * @package mssimi\ContentManagementBundle\Form
 * @author Marek Šimeček <mssimi@seznam.cz>
 */
class MenuItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', null, array(
                'label' => 'menu.label',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('linkType', ChoiceType::class, array(
                'label' => 'menu.linkType',
                'choices' => array(
                    'menu.linkType'.ucfirst(MenuItem::linkTypeUrl) => MenuItem::linkTypeUrl,
                    'menu.linkType'.ucfirst(MenuItem::linkTypeRoute) => MenuItem::linkTypeRoute,
                    'menu.linkType'.ucfirst(MenuItem::linkTypePath) => MenuItem::linkTypePath,
                    'menu.linkType'.ucfirst(MenuItem::linkTypePage) => MenuItem::linkTypePage,
                ),
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('link', null, array(
                'label' => 'menu.link',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('targetBlank', null, array(
                'label' => 'menu.targetBlank',
                'attr' => array(
                    'class' => ''
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MenuItem::class
        ));
    }
}
