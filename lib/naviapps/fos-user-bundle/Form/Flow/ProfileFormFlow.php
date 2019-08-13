<?php

namespace Naviapps\Bundle\FOSUserBundle\Form\Flow;

use Craue\FormFlowBundle\Form\FormFlow;

class ProfileFormFlow extends FormFlow
{
    /**
     * @var string
     */
    private $type;

    /**
     * @param string $type The type of the form
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return [
            [
                'label' => 'profile',
                'form_type' => $this->type,
            ],
        ];
    }
}
