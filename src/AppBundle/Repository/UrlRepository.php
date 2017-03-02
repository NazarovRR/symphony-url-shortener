<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 01.03.17
 * Time: 17:18
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Url;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping;

class UrlRepository extends EntityRepository
{
    private $em;

    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    public function insertData($model)
    {
        $this->em->persist($model);
        $this->em->flush();
        return $model;
    }

    public function isShortUnique($short)
    {
        if(!$short) return TRUE;
        $duplicateModel = $this->findOneBy(
            array('encoded' => $short)
        );
        if($duplicateModel){
            return FALSE;
        } else {
            return TRUE;
        }
    }
}