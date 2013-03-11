<?php
namespace Rayku\StaticBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('fullname', 'text');
        $builder->add('email', 'email');
        $builder->add('password', 'password');
        $builder->add('password_confirm', 'password');
        $builder->add('login_email', 'email');
        $builder->add('login_password', 'password');
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\StaticBundle\Entity\User',
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