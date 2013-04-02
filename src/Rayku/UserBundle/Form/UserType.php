<?php

namespace Rayku\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('first_name')
            ->add('last_name')
            ->add('school')
            ->add('grade')
            ->add('school_type')
            ->add('degree')
            ->add('bio')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\UserBundle\Entity\User',
        	'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
