<?php
namespace Rayku\StaticBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('fullname', 'text');
        $builder->add('email', 'email');
        $builder->add('password', 'password');
        $builder->add('email1', 'email');
        $builder->add('password1', 'password');
        $builder->add('confirm_password', 'password');

    }

    public function getName()
    {
        return 'task';
    }
}
?>