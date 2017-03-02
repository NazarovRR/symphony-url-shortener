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
                    echo "test1  ";
                    $encoderService = $this->container->get("encoder");
                    echo "test2  ";
                    $count = $model->getId();
                    echo "test3  ";
                    $hash = $encoderService->encode($count,false,3,"umbrella");
                    echo "test4  ";
                    while(!$repository->isShortUnique($hash)){
                        echo "test5  ";
                        $new_count = $count * 100;
                        echo "test6  ";
                        $hash = $encoderService->encode($new_count,false,3,"umbrella");
                        echo "test7  ";
                    }
                    echo "test8  ";
                    $model->setEncoded($hash);
                    echo "test9  ";
                    $model = $repository->insertData($model);
                    echo "test10  ";
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