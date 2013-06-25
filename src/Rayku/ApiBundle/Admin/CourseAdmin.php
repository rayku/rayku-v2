<?php
namespace Rayku\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class CourseAdmin extends Admin
{	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('name')
		;
	}
	
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
            ->add('name')
            ->add('instructor')
		;
	}
	
	// Allows for filtering
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('instructor')
        ;
    }
    
	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->addIdentifier('name', null, array('route' => array('name' => 'show')))
        ;
    }
}