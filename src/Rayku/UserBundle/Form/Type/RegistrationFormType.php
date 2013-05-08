<?php

namespace Rayku\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add('coupon', 'coupon_code', array('required' => false));
		$builder->remove('plainPassword');
		$builder->add('plainPassword', 'password', array('label' => 'Password'));
		$builder->add('signup_question', NULL, array('required' => false));
	}
	
	public function getName()
	{
		return 'rayku_user_registration';
	}
}