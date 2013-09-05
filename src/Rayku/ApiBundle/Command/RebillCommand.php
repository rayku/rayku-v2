<?php

namespace Rayku\ApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Rayku\ApiBundle\Entity\User;
use Rayku\ApiBundle\Entity\Invoice;

class RebillCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('rebill:execute')
			->setDescription('Rebill all users that have dropped below their rebill threshold');
	}
	
	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		parent::initialize($input, $output); //initialize parent class method
		$this->em = $this->getContainer()->get('doctrine')->getEntityManager(); // This loads Doctrine, you can load your own services as well
	}
	

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$users = $this->em->createQuery('
			SELECT u FROM RaykuApiBundle:User u
			JOIN u.credit_card c WHERE
			u.points < u.point_threshold AND
			u.point_threshold > 0 AND
			u.point_purchase > 0
		')->getResult();
		
		$progress = $this->getHelperSet()->get('progress');
		$progress->start($output, count($users));
		foreach($users as $user){
			$invoice = new Invoice();
			$invoice->setUser($user);
			$invoice->setCost($user->getPointPurchase()/INVOICE::POINTS_COST);
			
			$this->em->persist($invoice);
			
			$gateway = $this->getContainer()->get('rayku_payment_gateway')->setApiKey(
				$this->getContainer()->getParameter('payment.gateway.api_key')
			);
			
			$result = $this->getContainer()->get('rayku_payment_processor')->process($invoice, $user->getCreditCard(), $gateway);
			
			if(!$result['success']){
				$output->writeln('<error>'.$result['message'].'</error>');
			}
			
			$progress->advance();
		}
		
		$progress->finish();
	}
}