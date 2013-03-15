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
			->with('General')
				->add('username')
				->add('email')
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
           	->add('question')
           	//->add('start_time')
            //->add('end_time')
        ;
    }
	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->add('Username')
        	->add('Email')
            ->addIdentifier('Duration')
            ->addIdentifier('Rating')
            ->addIdentifier('Rate')
           	->addIdentifier('Question')
           	//->addIdentifier('Start')
            //->addIdentifier('End')
        ;
    }
}