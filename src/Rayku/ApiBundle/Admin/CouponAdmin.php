<?php
namespace Rayku\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class CouponAdmin extends Admin
{	
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('coupon')
			->add('credit')
			->add('expirationCount')
			->add('expirationDate')
		;
	}
	
	protected function configureShowFields(ShowMapper $showMapper)
	{
		$showMapper
            ->add('coupon')
            ->add('credit')
            ->add('used')
            ->add('expirationCount')
            ->add('expirationDate')
            ->add('createdAt', 'datetime')
		;
	}
	
	// Allows for filtering
	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('coupon')
            ->add('credit')
            ->add('expirationCount')
            ->add('expirationDate')
        ;
    }
    
	protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        	->addIdentifier('id', null, array('route' => array('name' => 'show')))
            ->add('coupon')
            ->add('credit')
            ->add('expirationCount')
            ->add('expirationDate')
            ->add('starttime', 'datetime')
            ->add('endtime', 'datetime')
        ;
    }
}