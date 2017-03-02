<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 02.03.17
 * Time: 9:42
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 */

class IsValidUrl extends Constraint
{
    public $message = "Url to be shorten is not valid";
}