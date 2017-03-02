<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 01.03.17
 * Time: 18:37
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 */
class ModelExist extends Constraint
{
    public $message = "This short url already taken";

    public function validatedBy()
    {
        return 'unique.model.validator';
    }
}