<?php

namespace Rayku\UserBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Rayku\ApiBundle\Entity\Coupon;

class CouponCodeTransformer implements DataTransformerInterface
{
	private $om;
	
	/*
	 * @var ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public function transform($coupon)
	{
		if(null === $coupon){
			return "";
		}
		return $coupon->getCode();
	}
	
	public function reverseTransform($code)
	{
		if(!$code){
			return null;
		}
		
		$coupon = $this->om->getRepository('RaykuApiBundle:Coupon')->findOneByCoupon($code);
		
		if(null === $coupon){
			throw new TransformationFailedException(sprintf(
				'An issue with number "%s" does not exist!',
				$code
			));
		}
		
		return $coupon;
	}
}