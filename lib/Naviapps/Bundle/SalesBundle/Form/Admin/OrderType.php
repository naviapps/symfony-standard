<?php

namespace Naviapps\Bundle\SalesBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    /** @var string */
    private $orderClass;

    /**
     * @param string $orderClass
     */
    public function __construct(string $orderClass)
    {
        $this->orderClass = $orderClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->orderClass,
        ]);
    }
}
