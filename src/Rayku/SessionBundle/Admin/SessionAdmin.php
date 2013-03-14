<?php
namespace Rayku\SessionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SessionAdmin extends Admin
{
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
            ->add('duration');
	}
	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('duration');
    }
}