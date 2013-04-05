<?php

namespace Rayku\TutorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TutorType extends AbstractType
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
    	$schoolAmountChoices = array_combine($schoolAmountChoices, $schoolAmountChoices);

        $builder
        	->add('schoolName', NULL, array(
        		'label' => 'School Name'		
        	))
        	->add('rate', NULL, array(
            	'label' => 'RP/Min'		
            ))
            ->add('degree')
            ->add('schoolAmount', 'choice', array(
            	'label' => 'What best describes you?',
            	'choices' => $schoolAmountChoices,
            	'required' => true	
           ))
            ->add('subjects', 'entity', array(
            	'multiple' => true,
            	'expanded' => true,
            	'class' => 'Rayku\TutorBundle\Entity\Subject'
            ))
            ->add('gtalk_email', NULL, array(
            	'label' => 'Connect Your Google Talk'
            )
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\TutorBundle\Entity\Tutor'
        ));
    }

    public function getName()
    {
        return 'rayku_tutorbundle_tutortype';
    }
}
