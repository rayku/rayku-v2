<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rayku\ApiBundle\Form\SessionTutorsType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question', 'hidden', array('required' => false))
            //->add('potential_tutors', 'collection', array('allow_add' => true))
            ->add('potential_tutors', 'collection', array(
            	'type' => new SessionTutorsType(),
            	'allow_add' => true)
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\ApiBundle\Entity\Session',
        	'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
