<?php

namespace Rayku\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SessionTutorsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tutor', NULL, array(
        	'class' => 'Rayku\ApiBundle\Entity\Tutor',
        	/*'query_builder' => function(EntityRepository $er){
        		return $er->createQueryBuilder('t');
        	}*/
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rayku\ApiBundle\Entity\SessionTutors'
        ));
    }

    public function getName()
    {
        return '';
    }
}
