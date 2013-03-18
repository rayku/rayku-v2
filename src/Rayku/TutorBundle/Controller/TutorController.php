<?php

namespace Rayku\TutorBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rayku\TutorBundle\Entity\Tutor;

/**
 * Tutor controller.
 *
 * @Route("/tutor")
 */
class TutorController extends Controller
{
    /**
     * Lists all Tutor entities.
     *
     * @Route("/", name="tutor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RaykuTutorBundle:Tutor')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Tutor entity.
     *
     * @Route("/{id}/show", name="tutor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaykuTutorBundle:Tutor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tutor entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

}
