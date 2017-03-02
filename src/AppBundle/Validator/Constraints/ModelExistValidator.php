<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 01.03.17
 * Time: 18:38
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

class ModelExistValidator extends ConstraintValidator
{
    private $em;
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if($value) {
            $encoded = $this->em->getRepository('AppBundle:Url')
                ->findOneBy(array('encoded' => $value));
            if ($encoded) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}