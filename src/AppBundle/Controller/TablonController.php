<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;

class TablonController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render(
            'tablon/index.html.twig',
            [
                'users' => $user,
            ]
        );
    }

    /**
     * @Route("/crear-mensaje", name="new_message")
     */
    public function newMessageAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'El mensaje se ha publicado correctamente.');

            return $this->redirectToRoute('homepage');
        }

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        return $this->render(
            'tablon/new_message.html.twig',
            [
                'users' => $user,
                'form' => $form->createView(),
            ]
        );
    }
}
