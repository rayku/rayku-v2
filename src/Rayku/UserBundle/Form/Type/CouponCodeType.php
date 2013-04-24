<?php

namespace Rayku\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rayku\UserBundle\Form\DataTransformer\CouponCodeTransformer;

class CouponCodeType extends AbstractType
{
	private $om;
	
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new CouponCodeTransformer($this->om);
		$builder->addModelTransformer($transformer);
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'invalid_message' => 'Invalid coupon code'
		));
	}
	
	public function getParent()
	{
		return 'text';
	}
	
	public function getName()
	{
		return 'coupon_code';
	}
}