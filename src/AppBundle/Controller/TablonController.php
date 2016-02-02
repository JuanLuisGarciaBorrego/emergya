<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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

    /**
     * @Route("/editar-user/{id}", name="message_edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user, ['token_user' => $this->getUser()]);
        $form->handleRequest($request);

        $formDelete = $this->formDeleteUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Has editado la fecha como administrador!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'tablon/edit_message.html.twig',
            [
                'form' => $form->createView(),
                'form_delete_user' => $formDelete->createView(),
            ]
        );
    }

    /**
     * @Route("/delete/{id}", name="message_delete")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(User $user, Request $request)
    {
        $form = $this->formDeleteUser($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $this->addFlash('success', 'Has eliminado un anuncio del tablón');
        }

        return $this->redirectToRoute('homepage');
    }

    private function formDeleteUser(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', ['id' => $user->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

}
