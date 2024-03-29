<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

use Rayku\ApiBundle\Entity\User;
use Rayku\ApiBundle\Form\UserType;
use Rayku\ApiBundle\Form\UserSettingType;
use Rayku\UserBundle\Form\Type\RegistrationAndProfileFormType;

/**
 * User controller.
 */
class UserController extends Controller
{
	
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
				$response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));
				$this->authenticateUser($user, $response);
				$route = 'fos_user_registration_confirmed';
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
	 * @ApiDoc(
	 *   description="Get user accounts - not implemneted",
	 *   resource=true
	 * )
	 */
	public function getUsersAction()
	{
		throw new \Exception('not implemented');
	}
	

	/**
	 * @View(serializerGroups={"user.view"})
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   },
	 *   description="Get a user record",
	 *   output="Rayku\ApiBundle\Entity\User"
	 * )
	 */
	public function getUserAction(User $entity)
	{
		return $entity;
	}
	
	/**
	 * @ApiDoc(
	 *   description="Update a user profile settings",
	 *   input="Rayku\ApiBundle\Form\UserSettingType"
	 * )
	 */
	public function postUsersProfileAction(User $user)
	{
		if($user->getId() !== $this->getUser()->getId()){
			throw new AccessDeniedException();
		}
		$request = $this->getRequest();
		$editForm = $this->createForm(new UserSettingType(), $user);
		$editForm->bind($request);
	
		if ($editForm->isValid()) {
			$em = $this->getDoctrine()->getEntityManager();
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
    	$request = $this->getRequest();
        $editForm = $this->createForm(new UserType(), $user);
        $editForm->bind($request);

        if ($editForm->isValid()) {
        	$em = $this->getDoctrine()->getEntityManager();
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
