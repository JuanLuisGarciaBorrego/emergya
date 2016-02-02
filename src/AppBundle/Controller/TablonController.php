<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TablonController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $user = new User();

        //$form = $this->createForm()

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render('tablon/index.html.twig', [
            'users' => $user
        ]);
    }
}
