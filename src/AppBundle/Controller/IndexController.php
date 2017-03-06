<?php
/**
 * Created by PhpStorm.
 * User: mikhailnazarov
 * Date: 28.02.17
 * Time: 15:11
 */

namespace AppBundle\Controller;


use AppBundle\Form\PostFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
   /**
    * @Route("/", name="base")
    */
   public function indexAction(Request $request)
   {
        // This is symfony form implementation, changed for an angular approach, for now
       // $form = $this->createForm(PostFormType::class);
       // $form->handleRequest($request);
       // $model = null;
       // if ($form->isSubmitted() && $form->isValid()) {
       //     $model = $form->getData();
       //     $updater = $this->container->get('encodeUpdater');
       //     $model = $updater->getEncodedModel($model);
       // }
       // return $this->render("index/show.html.twig",[
       //     "mainForm" => $form->createView(),
       //     "model" => $model
       // ]);
        //Angular view
        return $this->render("index/index_app.html.php");
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