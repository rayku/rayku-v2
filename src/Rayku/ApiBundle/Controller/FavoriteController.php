<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;

use Rayku\ApiBundle\Entity\Favorite;
use Rayku\ApiBundle\Form\FavoriteType;
/**
 * RestFavorite controller.
 */
class FavoriteController extends Controller
{
	/**
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
	 * @View()
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
     *     400="Returned when there is an error"
     *   },
	 *   description="Create/update order object",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\FavoriteType"
	 * )
	 */
	public function postFavoritesAction()
	{
		$favorite = new Favorite();
		$favorite->setSender($this->getUser());
		
		$form = $this->createForm(new FavoriteType(), $favorite)->bind($this->getRequest());
		
		if($form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->persist($favorite);
			$em->flush();
			return array('success' => true, 'favorite' => $favorite);
		}
		return $form;
	}
	
	private function processForm(Favorite $entity)
	{

	}
}

