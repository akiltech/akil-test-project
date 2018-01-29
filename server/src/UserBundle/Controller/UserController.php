<?php

namespace UserBundle\Controller;

use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("users")
 */
class UserController extends FOSRestController
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->json(array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Rest\View
     *
     * @Route("/", name="user_new")
     * @Method("POST")
     */
    public function postUserAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(['erreur' => 400, 'message' => 'Format de données invalide'], 400);
        }
        $user = new User();
        $form = $this->createForm('UserBundle\Form\UserType', $user);
        $form->submit($data);
        // $validator = $this->get('validator');
        // $violations = $validator->validate($user);
        // if (count($violations)) {
        //     return $this->view($violations, 400);
        // }
        $errors = $this->get('validator')->validate($user);

        if (count($errors)) {
            return $this->view($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_show', array('id' => $user->getId()));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function getUsertion(User $user)
    {
        return $this->json(array(
            'data' => $user,
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}", name="user_edit")
     * @Method("PUT")
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_index');
    }
}
