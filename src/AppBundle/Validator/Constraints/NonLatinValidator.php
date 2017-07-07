<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NonLatinValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value) {
            // on empty value returns valid
            return true;
        }

        if (strlen($value) != mb_strlen($value, 'UTF-8')) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%value%', $value)
                ->addViolation();

            return false;
        }

        return true;
    }
}
