<?php

namespace AppBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;

class RegistrationFlow extends FormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label'     => '',
                'form_type' => RegistrationType::class,
            ],
            [
                'label' => '',
            ],
        ];
    }
}
