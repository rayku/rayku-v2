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
    		"Freshman" => "Freshman",
    		"Sophomore" => "Sophomore",
    		"Junior" => "Junior",
   			"Senior" => "Senior",
   			"Masters Student" => "Masters Student",
   			"Phd Candidate" => "Phd Candidate",
   			"Undergrad Degree Holder" => "Undergrad Degree Holder",
    		"Masters Degree Holder" => "Masters Degree Holder",
    		"Phd Degree Holder" => "Phd Degree Holder",
    		"Teaching Assistant" => "Teaching Assistant",
   			"Professor" => "Professor",
   			"Middle School Teacher" => "Middle School Teacher",
   			"High School Teacher" => "High School Teacher"
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
