<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rayku\ApiBundle\Form\UserSchoolType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('bio')
            ->add('file')
            ->add('school')
            ->add('grade')
            ->add('degree');
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
