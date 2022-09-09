<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

class SumOfRangesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\SumOfRanges $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if ($value["oxygen"] + $value["nitrogen"] + $value["helium"] !== 100){
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
