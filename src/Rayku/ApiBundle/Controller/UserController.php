<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Rayku\ApiBundle\Entity\User;
use Rayku\ApiBundle\Form\UserType;
use Rayku\ApiBundle\Form\PointType;
use Rayku\ApiBundle\Form\UserSettingType;
use Rayku\UserBundle\Form\Type\RegistrationAndProfileFormType;
use Rayku\UserBundle\Form\Type\RegistrationAndTutorProfileFormType;

/**
 * User controller.
 */
class UserController extends Controller
{
	/**
	 * @ApiDoc(
	 *     description="Register a user / tutor account",
	 *     input="Rayku\UserBundle\Form\Type\RegistrationAndTutorProfileFormType"
	 * )
	 */
	public function postUsersTutorRegistrationAction()
	{
		$user = new User();
		
		$form = $this->createForm(new RegistrationAndTutorProfileFormType(get_class($user)), $user, array('csrf_protection' => false));
		$form->bind($this->getRequest());
		if($form->isValid()){
			$confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
			$this->container->get('fos_user.registration.form.handler')->processReferral($user, $confirmationEnabled);
			
			$em = $this->getDoctrine()->getManager();
			// shouldn't be necessary :(
			$tutor = $user->getTutor();
			$tutor->setUser($user);
			$em->persist($tutor);
			$em->persist($user);
			$em->flush();
			
			
			$route = 'rayku_page_dashboard';
			if ($confirmationEnabled) {
				$this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
			} else {
				$response = new RedirectResponse($this->container->get('router')->generate($route));
				$this->authenticateUser($user, $response);
			}
			
			$url = $this->container->get('router')->generate($route, array(), true);
			return array('success' => true, 'redirect' => $url);
		}
		
		return array(
			'entity' => $user,
			'form'   => $form,
		);
	}
	
	/**
	 * @ApiDoc(
	 *     description="Register a user",
	 *     input="Rayku\UserBundle\Form\Type\RegistrationAndProfileFormType"
	 * )
	 */
	public function postUsersRegistrationAction()
	{
		$user = new User();
		
		$form = $this->createForm(new RegistrationAndProfileFormType(get_class($user)), $user, array('csrf_protection' => false));
		$form->bind($this->getRequest());
		if ($form->isValid()) {
			$confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
			$this->container->get('fos_user.registration.form.handler')->processReferral($user, $confirmationEnabled);
		
			if ($confirmationEnabled) {
				$this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
				$route = 'fos_user_registration_check_email';
			} else {
				$route = 'fos_user_registration_confirmed';
				$response = new RedirectResponse($this->container->get('router')->generate($route));
				$this->authenticateUser($user, $response);
			}
		
			$url = $this->container->get('router')->generate($route, array(), true);
			return array('success' => true, 'redirect' => $url);
		}
		
		return array(
			'entity' => $user,
			'form'   => $form,
		);
	}
	
	/**
	 * @see \FOS\UserBundle\Controller\RegistrationController
	 * @param \User $user
	 * @param \RedirectResponse $response
	 */
	protected function authenticateUser($user, $response)
	{
		try {
			$this->container->get('fos_user.security.login_manager')->loginUser(
				$this->container->getParameter('fos_user.firewall_name'),
				$user,
				$response);
		} catch (AccountStatusException $ex) {
			// We simply do not authenticate users which do not pass the user
			// checker (not enabled, expired, etc.).
		}
	}

	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   },
	 *   resource=true,
	 *   description="Get a user record",
	 *   output="Rayku\ApiBundle\Entity\User"
	 * )
	 */
	public function getUserAction(User $user)
	{
		return $user;
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @ApiDoc(
	 *   description="Update a user points settings",
	 *   input="Rayku\ApiBundle\Form\PointType"
	 * )
	 * @View(serializerGroups={"user.details"})
	 */
	public function postUsersPointsAction(User $user)
	{
		if($user->getId() !== $this->getUser()->getId()){
			throw new AccessDeniedException();
		}
	
		$editForm = $this->createForm(new PointType(), $user);
		
		// Ignore extra fields that Angularjs sends with the form
		$data = $this->getRequest()->request->all();
		$children = $editForm->all();
		$data = array_intersect_key($data, $children);
	
		$editForm->bind($data);
	
		if ($editForm->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			return $user;
		}
		return array(
				'entity'      => $user,
				'edit_form'   => $editForm,
		);
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @ApiDoc(
	 *   description="Update a user profile settings",
	 *   input="Rayku\ApiBundle\Form\UserSettingType"
	 * )
	 * @View(serializerGroups={"user.details"})
	 */
	public function postUsersProfileAction(User $user)
	{
		if($user->getId() !== $this->getUser()->getId()){
			throw new AccessDeniedException();
		}
		
		$editForm = $this->createForm(new UserSettingType(), $user);
		 
		// Ignore extra fields that Angularjs sends with the form
		$data = $this->getRequest()->request->all();
		$children = $editForm->all();
		$data = array_intersect_key($data, $children);
		
		$editForm->bind($data);
	
		if ($editForm->isValid()) {
			if(isset($data['plainPassword']['first'])){
				$user->setPassword($data['plainPassword']['first']);
			}
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			return $user;
		}
		
		return array(
			'entity'      => $user,
			'edit_form'   => $editForm,
		);
	}
	
    /**
     * @Secure(roles="ROLE_USER")
     * @ApiDoc(
     *   description="Update a user profile settings",
     *   input="Rayku\ApiBundle\Form\UserType"
     * )
     */
    public function postUsersAction(User $user)
    {
    	if($user->getId() !== $this->getUser()->getId()){
    		throw new AccessDeniedException();
    	}
    	
    	$editForm = $this->createForm(new UserType(), $user);
        $editForm->bind($this->getRequest());

        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $user;
        }
        return array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
        );
    }
}
