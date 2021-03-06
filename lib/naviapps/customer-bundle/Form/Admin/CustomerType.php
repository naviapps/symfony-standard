<?php

namespace Naviapps\Bundle\CustomerBundle\Form\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    /** @var string */
    private $customerClass;

    /**
     * @param string $customerClass
     */
    public function __construct(string $customerClass)
    {
        $this->customerClass = $customerClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'label.email',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'required'        => false,
                'first_options'   => ['label' => '新しいパスワード'],
                'second_options'  => ['label' => '新しいパスワードの確認'],
                'invalid_message' => '入力されたパスワードが一致しません',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->customerClass,
        ]);
    }
}
