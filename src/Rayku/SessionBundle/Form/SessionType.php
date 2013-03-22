<?php

namespace Rayku\SessionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime', NULL, array(
				    'input'  => 'datetime',
				    'widget' => 'single_text',
				))
            ->add('endTime', 'date')
            ->add('duration')
            ->add('rating')
            ->add('rate')
            ->add('question')
            ->add('recordingId')
            ->add('student')
            ->add('tutor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\SessionBundle\Entity\Session',
            'csrf_protection'   => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
