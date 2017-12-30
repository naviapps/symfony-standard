<?php

namespace App\Form;

use Naviapps\Bundle\FOSUserBundle\Form\Flow\RegistrationFormFlow;

class RegistrationFlow extends RegistrationFormFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array_merge(parent::loadStepsConfig(), [
            [
                'label' => 'confirmation',
            ],
        ]);
    }
}
