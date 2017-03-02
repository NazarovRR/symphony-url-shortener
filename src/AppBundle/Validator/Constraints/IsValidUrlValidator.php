<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 02.03.17
 * Time: 9:43
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidUrlValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if($value) {
            $headers = @get_headers($value);
            $string = '200 OK';
            $flag = TRUE;
            if (is_array($headers)) {
                foreach ($headers as $header) {
                    if (strpos($header, $string) !== FALSE) {
                        //match found, looks like one of the redirected responses is OK.
                        $flag = FALSE;
                    }
                }
            }
            if($flag)
            {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}