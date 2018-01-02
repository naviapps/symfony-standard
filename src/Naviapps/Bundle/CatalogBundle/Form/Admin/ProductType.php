<?php

namespace Naviapps\Bundle\CatalogBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /** @var string */
    private $productClass;

    /**
     * @param string $productClass
     */
    public function __construct(string $productClass)
    {
        $this->productClass = $productClass;
    }

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
            'data_class'         => $this->productClass,
            'translation_domain' => 'NaviappsCatalogBundle',
        ]);
    }
}
