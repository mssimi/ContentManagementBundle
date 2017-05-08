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
                'label' => 'mssimiContentManagement.menu.form.label',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('link', null, array(
                'label' => 'mssimiContentManagement.menu.form.link',
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('linkType', ChoiceType::class, array(
                'label' => 'mssimiContentManagement.menu.form.linkType',
                'choices' => array(
                    'mssimiContentManagement.menu.form.linkType'.ucfirst(MenuItem::linkTypeUrl) => MenuItem::linkTypeUrl,
                    'mssimiContentManagement.menu.form.linkType'.ucfirst(MenuItem::linkTypeRoute) => MenuItem::linkTypeRoute,
                    'mssimiContentManagement.menu.form.linkType'.ucfirst(MenuItem::linkTypePath) => MenuItem::linkTypePath,
                ),
                'attr' => array(
                    'class' => ''
                )
            ))
            ->add('targetBlank', null, array(
                'label' => 'mssimiContentManagement.menu.form.targetBlank',
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

    public function getName()
    {
        return 'content_management_bundle_menu_type';
    }
}
