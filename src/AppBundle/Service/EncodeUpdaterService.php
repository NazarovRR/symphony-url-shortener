<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 03.03.17
 * Time: 10:54
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

class EncodeUpdaterService
{
    private $em;
    private $encoder;

    function __construct(EntityManager $entityManager, $encoder)
    {
        $this->em = $entityManager;
        $this->encoder = $encoder;
    }

    public function getEncodedModel($model)
    {
        $repository = $this->em->getRepository('AppBundle:Url');
        $existedModel = $repository->findOneBy(
            array('full_url' => $model->getFullUrl())
        );
        if($existedModel && $existedModel->getEncoded())
        {
            $model = $existedModel;
        }
        else
        {
            $model = $repository->insertData($model);
            if(!$model->getEncoded())
            {
                $count = $model->getId();
                $hash = $this->encoder->encode($count,false,3,"umbrella");
                while(!$repository->isShortUnique($hash)){
                    $new_count = $count * 100;
                    $hash = $this->encoder->encode($new_count,false,3,"umbrella");
                }
                $model->setEncoded($hash);
                $model = $repository->insertData($model);
            }
        }
        return $model;
    }
}