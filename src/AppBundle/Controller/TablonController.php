<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TablonController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render('tablon/index.html.twig', [
            'users' => $user
        ]);
    }
}
