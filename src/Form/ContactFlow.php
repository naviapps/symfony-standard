<?php

namespace App\Form;

use Craue\FormFlowBundle\Form\FormFlow;

class ContactFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label'     => 'title.contact',
                'form_type' => ContactType::class,
            ],
            [
                'label' => 'confirmation',
            ],
        ];
    }
}
