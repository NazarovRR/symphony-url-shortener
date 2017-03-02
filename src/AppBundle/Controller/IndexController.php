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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="base")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Url');
        $form = $this->createForm(PostFormType::class);
        $form->handleRequest($request);
        $model = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
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
                    $encoderService = $this->container->get("encoder");
                    $count = $model->getId();
                    $hash = $encoderService->encode($count,false,3,"umbrella");
                    while(!$repository->isShortUnique($hash)){
                        $new_count = $count * 100;
                        $hash = $encoderService->encode($new_count,false,3,"umbrella");
                    }
                    $model->setEncoded($hash);
                    $model = $repository->insertData($model);
                }
            }
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
}