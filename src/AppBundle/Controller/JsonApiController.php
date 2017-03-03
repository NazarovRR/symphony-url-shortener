<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 03.03.17
 * Time: 12:10
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Url;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JsonApiController extends Controller
{
    /**
     * @Route("/api/v1/create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {   $params = array();
        $body = $request->getContent();
        if (!empty($body))
        {
            $params = json_decode($body, true);
        }
        $model = new Url();
        $model->setFullUrl(@$params['full_url']);
        if(@$params['encoded'])
        {
            $model->setEncoded($params['encoded']);
        }
        $validator = $this->get("validator");
        $violations = $validator->validate($model);
        if (count($violations) > 0) {
            $errors = array();
            foreach ($violations as &$error) {
                array_push($errors,$error->getMessage());
            }
            unset($error);
            $data = array(
                "errors"=>$errors,
                "message"=>"validation error"
            );
            return new JsonResponse($data,400);
        }
        $updater = $this->container->get('encodeUpdater');
        $model = $updater->getEncodedModel($model);
        $data = array(
            "encoded"=>$model->getEncoded(),
            "message"=>"Success"
        );
        return new JsonResponse($data);
    }
}