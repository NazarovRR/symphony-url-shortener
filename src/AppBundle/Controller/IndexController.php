<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 28.02.17
 * Time: 15:11
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Url;
use AppBundle\Form\PostFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="base")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(PostFormType::class);
        $form->handleRequest($request);
        $model = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
            $updater = $this->container->get('encodeUpdater');
            $model = $updater->getEncodedModel($model);
        }
        return $this->render("index/show.html.twig",[
            "mainForm" => $form->createView(),
            "model" => $model
        ]);
    }

    /**
     * @param $encoded
     * @Route("/{encoded}", name="redir")
     * @Method("GET")
     */
    public function redirectAction($encoded)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Url');
        $existedModel = $repository->findOneBy(
            array('encoded' => $encoded)
        );
        if($existedModel) {
            return $this->redirect($existedModel->getFullUrl(), 301);
        } else {
            return $this->redirect("/");
        }
    }

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