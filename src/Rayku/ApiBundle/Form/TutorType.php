<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TutorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$schoolAmountChoices = array(
    				"",
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
    	$schoolAmountChoices = array_combine($schoolAmountChoices, $schoolAmountChoices);

        $builder
         	->add('rate', NULL, array(
            	'label' => 'RP/Min $1 = 100 RP'		
            ))
             ->add('gtalk_email', NULL, array(
            	'label' => 'Connect Your Google Talk'
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\ApiBundle\Entity\Tutor',
        	'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
