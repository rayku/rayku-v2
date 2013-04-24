<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Rayku\ApiBundle\Entity\User;
use Rayku\ApiBundle\Form\UserType;

/**
 * User controller.
 */
class UserController extends Controller
{
	/**
	 * @ApiDoc(
	 *   description="Get user accounts - not implemneted",
	 *   resource=true
	 * )
	 */
	public function getUsersAction()
	{
		
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
