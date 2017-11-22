<?php

namespace AppBundle\Form;

use Naviapps\Bundle\UserBundle\Form\Flow\RegistrationFormFlow as BaseFlow;

class RegistrationFlow extends BaseFlow
{
    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array_merge(parent::loadStepsConfig(), [
            [
                'label' => '',
            ],
        ]);
    }
}
