<?php

namespace Rayku\ApiBundle;

use Rayku\ApiBundle\Entity\Invoice;
use Rayku\ApiBundle\Entity\CreditCard;
use Rayku\ApiBundle\Entity\Transaction;

class ProcessTransaction
{
	protected $em;
	
	public function __construct($doctrine)
	{
		$this->em = $doctrine->getManager();
	}
	
	public function process(Invoice $invoice, CreditCard $card, $gateway)
	{
		$user = $card->getUser();
		$response = $gateway->purchase(array(
				'amount' => $invoice->getCost(),
				'currency' => 'CAD',
				'cardReference' => $card->getReference()
		))->send();

		$transaction = new Transaction();
		$transaction->setUser($user);
		$transaction->setCard($card);
		$transaction->setCost($invoice->getCost());
		$transaction->setReference($response->getTransactionReference());
		$transaction->setData(serialize($response->getData()));
		
		if($response->isSuccessful()){
			$transaction->setStatus('successful');
			$invoice->setStatus('successful');
			$this->em->persist($invoice);
			$this->em->persist($transaction);
			$this->em->flush();
			return array('success' => true, 'invoice' => $invoice);
		}
		
		$transaction->setStatus('failed');
		$this->em->persist($transaction);
		$this->em->flush();
		return array('success' => false, 'invoice' => $invoice, 'message' => $response->getMessage());
	}
}