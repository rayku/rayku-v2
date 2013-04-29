<?php
namespace Rayku\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class SessionAdmin extends Admin
{
	protected function configureRoutes(RouteCollection $collection)
	{
		$collection
			->remove('create')
			->remove('delete')
			->remove('edit')
		;
	}
	
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
			->add('id')
            ->add('duration')
            ->add('rating')
            ->add('rate')
            ->add('student')
            ->add('selected_tutor')
            ->add('question')
            ->add('starttime', 'datetime')
            ->add('endtime', 'datetime')
            ->add('potential_tutors', 'many_to_one')
		;
	}
	
	// Allows for filtering
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('duration')
            ->add('rating')
            ->add('rate')
            ->add('student')
        ;
    }
    
	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->addIdentifier('id', null, array('route' => array('name' => 'show')))
        	->add('Student')
        	->add('StartTime', 'datetime')
            ->add('Duration')
            ->add('Rating')
            ->add('Rate')
           	->add('Question')
           	->add('CreatedAt', 'datetime')
        ;
    }
}