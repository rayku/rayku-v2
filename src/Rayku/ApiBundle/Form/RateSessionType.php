<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rayku\ApiBundle\Form\SessionTutorsType;

class RateSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('rating', 'choice', array(
        	'choices' => array('poor', 'satisfactory', 'average', 'good', 'excellent')	,
        	'required' => true,
    		'attr' => array('class' => 'medium')
    	));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\ApiBundle\Entity\Session'
        ));
    }

    public function getName()
    {
        return '';
    }
}
