<?php

namespace Rayku\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Rayku\ApiBundle\Form\TutorType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationAndTutorProfileFormType extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder
			->add('first_name', NULL, array('label' => 'First Name'))
			->add('last_name', NULL, array('label' => 'Last Name'))
			->remove('signup_question')
			->remove('plainPassword')
			->add('plainPassword', 'password', array('label' => 'Password'))
			->add('tutor', new TutorType())
		;
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