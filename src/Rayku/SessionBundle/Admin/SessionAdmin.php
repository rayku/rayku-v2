<?php
namespace Rayku\SessionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SessionAdmin extends Admin
{
    /*protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('username')
            ->add('email')
        ;
    }*/

	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('username')
        ;
	}

	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('Username')
        ;
    }
}