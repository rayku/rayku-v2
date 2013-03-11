<?php
namespace Rayku\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('fullname', 'text');
        $builder->add('email', 'email');
        $builder->add('UserPassword', 'repeated', array(
           'first_name'  => 'password',
           'second_name' => 'confirm',
           'type'        => 'password',
        ));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}
?>