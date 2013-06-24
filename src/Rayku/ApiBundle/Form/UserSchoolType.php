<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserSchoolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$schoolAmountChoices = array(
    		"Freshman",
    		"Sophomore",
    		"Junior",
   			"Senior",
   			"Masters Student",
   			"Phd Candidate",
   			"Undergrad Degree Holder",
    		"Masters Degree Holder",
    		"Phd Degree Holder",
    		"Teaching Assistant",
   			"Professor",
   			"Middle School Teacher",
   			"High School Teacher"
    	);
        $builder
	        ->add('school', 'choice', array(
	        	'label' => 'What best describes you?',
	        	'choices' => $schoolAmountChoices,
	        	'required' => true
	       ))
            ->add('grade')
            ->add('degree')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        	'virtual' => true
       ));
    }

    public function getName()
    {
        return 'userschool';
    }
}
