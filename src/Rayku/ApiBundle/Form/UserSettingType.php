<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserSettingType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('username', null, array(
				'label' => 'form.username', 
				'translation_domain' => 'FOSUserBundle'
		));
		$builder->add('email', 'email', array(
				'label' => 'form.email', 
				'translation_domain' => 'FOSUserBundle'
		));
		$builder->add('current_password', 'password', array(
				'label' => 'form.current_password',
				'translation_domain' => 'FOSUserBundle',
				'mapped' => false,
				'constraints' => new UserPassword(),
		));
		$builder->add('plainPassword', 'repeated', array(
			'type' => 'password',
			'options' => array('translation_domain' => 'FOSUserBundle'),
			'first_options' => array('label' => 'form.new_password'),
			'second_options' => array('label' => 'form.new_password_confirmation'),
			'invalid_message' => 'fos_user.password.mismatch',
		));
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Rayku\ApiBundle\Entity\User',
			'csrf_protection' => false
		));
	}
	
	public function getName()
	{
		return '';
	}
}