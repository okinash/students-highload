<?php

namespace Kinash\StudentsDatabaseBundle\Controller;

use Doctrine\Common\Util\Debug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StudentsDatabaseBundle:Default:index.html.twig', array());
    }


    public function detailAction($path){
        $repo = $this->getDoctrine()->getManager()->getRepository('Kinash\StudentsDatabaseBundle\Entity\Student');
        $student = $repo -> findOneBy(array('path' => $path));

        $response = $this->render('StudentsDatabaseBundle:Default:detail.html.twig', array('student' => $student));
        $response->setMaxAge(900);
        $response->setPublic();
        return $response;
    }
}
