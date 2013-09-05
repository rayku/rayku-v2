<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'First Name',
            	'required' => true))
            ->add('lastName', 'text', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'Last Name',
            	'required' => true))
            ->add('number', 'text', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'Credit Card Number',
            	'required' => true))
            ->add('expiryYear', 'integer', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'Expiry Year',
            	'required' => true))
            ->add('expiryMonth', 'integer', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'Expiry Month',
            	'required' => true))
            ->add('cvv', 'integer', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'CCV',
            	'required' => true))
            ->add('type', 'text', array(
            	'constraints' => array(new NotBlank()),
            	'label' => 'Type',
            	'required' => true))
            ->add('billingAddress1', 'text', array('label' => 'Address'))
            ->add('billingCity', 'text', array('label' => 'City'))
            ->add('billingPostcode', 'text', array('label' => 'Postal Code'))
            ->add('billingState', 'text', array('label' => 'Province / State'))
            ->add('billingCountry', 'text', array('label' => 'Country'))
            ->add('current_password', 'password', array(
            	'label' => 'form.current_password',
            	'translation_domain' => 'FOSUserBundle',
            	'mapped' => false,
            	'constraints' => new UserPassword(),
            ));
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    	$resolver->setDefaults(array(
    		'csrf_protection' => false,
    		'cascade_validation' => true,
    	));
    }

    public function getName()
    {
        return '';
    }
}
