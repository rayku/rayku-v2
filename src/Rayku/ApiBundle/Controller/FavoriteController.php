<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Rayku\ApiBundle\Entity\Favorite;
use Rayku\ApiBundle\Form\FavoriteType;
/**
 * RestFavorite controller.
 */
class FavoriteController extends Controller
{
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View(serializerGroups={"favorite.details", "user"})
	 * @ApiDoc(
	 *   description="Get the current user's favorited users",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 */
	public function getFavoritesAction()
	{
		$em = $this->getDoctrine()->getManager();
		$sessions = $em->getRepository('RaykuApiBundle:Favorite')->findBySender($this->getUser());
	
		return $sessions;
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View(serializerGroups={"favorite.details", "user"})
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful"
     *   },
	 *   description="Get a favorite record",
	 *   output="Rayku\ApiBundle\Entity\Favorite"
	 * )
	 */
	public function getFavoriteAction(Favorite $favorite)
	{
		return $favorite;
	}
	

	/**
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful",
	 *     403="Returned when the user is not authorized"
	 *   },
	 *   description="Delete a favorite record"
	 * )
	 * @SecureParam(name="entity", permissions="DELETE")
	 */
	public function deleteFavoritesAction(Favorite $entity)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($entity);
		$em->flush();
			
		return array('success' => true);
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View(serializerGroups={"favorite.details", "user"})
	 * @ApiDoc(
	 *   statusCodes={
     *     200="Returned when successful",
     *     400="Returned when there is an error"
     *   },
	 *   description="Order object",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\FavoriteType"
	 * )
	 */
	public function postFavoritesAction()
	{
		$favorite = new Favorite();
		$favorite->setSender($this->getUser());
		return $this->processForm($favorite);
	}
	
	private function processForm(Favorite $favorite){
		$new = (null === $favorite->getId()) ? true : false;
		$form = $this->createForm(new FavoriteType(), $favorite)->bind($this->getRequest());
		
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($favorite);
			$em->flush();
			
			if($new){
				// creating the ACL
				$aclProvider = $this->get('security.acl.provider');
				$objectIdentity = ObjectIdentity::fromDomainObject($favorite);
				$acl = $aclProvider->createAcl($objectIdentity);
				 
				// retrieving the security identity of the currently logged-in user
				$securityContext = $this->get('security.context');
				$user = $securityContext->getToken()->getUser();
				$securityIdentity = UserSecurityIdentity::fromAccount($user);
				 
				// grant owner access
				$acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
				$aclProvider->updateAcl($acl);
			}
			
			return array('success' => true, 'favorite' => $favorite);
		}
		return $form;
	}
}

