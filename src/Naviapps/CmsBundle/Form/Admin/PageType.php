<?php

namespace Naviapps\CmsBundle\Form\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Naviapps\CmsBundle\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'label.page_title',
            ])
            ->add('content', CKEditorType::class, [
                'required' => false,
            ])
            ->add('identifier', null, [
                'label' => 'label.url_key',
            ])
            ->add('metaKeywords', null, [
                'label'    => 'label.meta_keywords',
                'required' => false,
            ])
            ->add('metaDescription', null, [
                'label'    => 'label.meta_description',
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
