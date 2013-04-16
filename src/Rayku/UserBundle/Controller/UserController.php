<?php

namespace Rayku\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Rayku\UserBundle\Entity\User;
use Rayku\UserBundle\Form\UserType;
use Rayku\UserBundle\Form\UserSettingType;

/**
 * User controller.
 */
class UserController extends Controller
{
	/**
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Update a user profile settings",
	 *   input="Rayku\UserBundle\Form\UserType"
	 * )
	 */
	public function postUserProfileAction(User $user)
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
     *   resource=true,
     *   description="Update a user profile settings",
     *   input="Rayku\UserBundle\Form\UserType"
     * )
     */
    public function postUserAction(User $user)
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
