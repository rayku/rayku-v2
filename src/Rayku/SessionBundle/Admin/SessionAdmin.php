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
			->with('General')
            	->add('duration')
            	->add('rating')
            	->add('rate')
            	->add('question')
            	//->add('start_time')
            	//->add('end_time')
            ->end()
        ;
	}
	// Allows for filtering
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('duration')
            ->add('rating')
            ->add('rate')
        ;
    }
	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('Duration')
            ->addIdentifier('Rating')
            ->addIdentifier('Rate')
           	->addIdentifier('Question')
        ;
    }
}