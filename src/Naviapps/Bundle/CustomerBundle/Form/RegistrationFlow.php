<?php

namespace Naviapps\Bundle\CustomerBundle\Form;

use Naviapps\Bundle\FOSUserBundle\Form\Flow\RegistrationFormFlow as BaseFormFlow;

class RegistrationFlow extends BaseFormFlow
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
