<?php

namespace Rayku\ApiBundle\Form;

use FOS\MessageBundle\FormType\NewThreadMessageFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Message form type for starting a new conversation
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class NewThreadType extends NewThreadMessageFormType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention'  => 'message',
    		'csrf_protection' => false
    	));
    }
    
    public function getName()
    {
    	return 'message';
    }
}
