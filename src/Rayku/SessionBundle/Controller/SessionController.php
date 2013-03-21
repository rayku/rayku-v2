<?php

namespace Rayku\SessionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rayku\SessionBundle\Entity\Session;
use Rayku\SessionBundle\Form\SessionType;

/**
 * Session controller.
 *
 * @Route("/session")
 */
class SessionController extends Controller
{

    /**
     * Displays a form to create a new Session entity.
     *
     * @Route("/new", name="session_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Session();
        $form   = $this->createForm(new SessionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Session entity.
     *
     * @Route("/create", name="session_create")
     * @Method("POST")
     * @Template("RaykuSessionBundle:Session:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Session();
        $form = $this->createForm(new SessionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('session_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Session entity.
     *
     * @Route("/{id}/edit", name="session_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaykuSessionBundle:Session')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Session entity.');
        }

        $editForm = $this->createForm(new SessionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Session entity.
     *
     * @Route("/{id}/update", name="session_update")
     * @Method("POST")
     * @Template("RaykuSessionBundle:Session:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaykuSessionBundle:Session')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Session entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SessionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('session_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Session entity.
     *
     * @Route("/{id}/delete", name="session_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RaykuSessionBundle:Session')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Session entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('session'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
