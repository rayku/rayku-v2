<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class PointType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('point_threshold');
		$builder->add('point_purchase');
		$builder->add('current_password', 'password', array(
				'label' => 'form.current_password',
				'translation_domain' => 'FOSUserBundle',
				'mapped' => false,
				'constraints' => new UserPassword(),
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