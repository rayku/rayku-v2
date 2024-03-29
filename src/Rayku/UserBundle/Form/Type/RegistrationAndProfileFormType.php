<?php

namespace Rayku\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationAndProfileFormType extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder
			->add('signup_question', 'hidden', array('required' => false))
			->add('first_name', NULL, array('label' => 'First Name'))
			->add('last_name', NULL, array('label' => 'Last Name'))
			->add('signup_question', 'hidden', array('required' => false));
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		parent::setDefaultOptions($resolver);
		
		$resolver->setDefaults(array(
			'csrf_protection' => false,
			'validation_groups' => array('registration')
		));
	}
	
	public function getName()
	{
		return '';
	}
}