<?php

namespace Naviapps\Bundle\CatalogBundle\Form\Admin;

use Naviapps\Bundle\CatalogBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'label.product_name',
            ])
            ->add('categories', null, [
                'label' => 'label.categories',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => Product::class,
            'translation_domain' => 'NaviappsCatalogBundle',
        ]);
    }
}
