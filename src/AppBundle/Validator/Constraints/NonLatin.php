<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class NonLatin extends Constraint
{
    public $message = 'The value "%value%" must contain only Latin characters.';

    /**
     * @inheritdoc
     */
    public function validatedBy()
    {
        return NonLatinValidator::class;
    }
}
