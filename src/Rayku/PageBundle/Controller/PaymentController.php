<?php

namespace Rayku\PageBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use JMS\Payment\CoreBundle\Entity\Payment;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Rayku\ApiBundle\Entity\Order;

/**
 * @Route("/payments")
 * Controller is a good candidate to be extracted into it's own bundle
 */
class PaymentController extends Controller
{
    /** @DI\Inject */
    private $request;

    /** @DI\Inject */
    private $router;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /** @DI\Inject("payment.plugin_controller") */
    private $ppc;

    /**
     * @Route("/{id}/details", name = "rayku_payment_details")
     * @Template
     */
    public function detailsAction(Order $order)
    {
        $form = $this->getFormFactory()->create('jms_choose_payment_method', null, array(
            'amount'   => $order->getAmount(),
            'currency' => 'CAD',
            'predefined_data' => array(
                'paypal_express_checkout' => array(
                    'return_url' => $this->router->generate('rayku_payment_complete', array(
                        'id' => $order->getId(),
                    ), true),
                    'cancel_url' => $this->router->generate('rayku_payment_cancel', array(
                        'id' => $order->getId(),
                    ), true),
                	'checkout_params' => array(
	                	'NOSHIPPING' => 1,
	                	'REQCONFIRMSHIPPING' => 0,
	                	'PAYMENTREQUEST_0_DESC' => 'Rayku point purchase'
                	)
                ),
            ),
        ));

        if ('POST' === $this->request->getMethod()) {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->ppc->createPaymentInstruction($instruction = $form->getData());

                $order->setPaymentInstruction($instruction);
                $this->em->persist($order);
                $this->em->flush($order);

                return new RedirectResponse($this->router->generate('rayku_payment_complete', array(
                    'id' => $order->getId(),
                )));
            }
        }

        return array(
            'form' => $form->createView(),
        	'order_id' => $order->getId()
        );
    }
    
    /**
     * @Route("/{id}/cancel", name = "rayku_payment_cancel")
     */
    public function cancelAction(Order $order )
    {
    	die(__LINE__.' '.__FILE__);
    }
    
    /**
     * @Route("/{id}/complete", name = "rayku_payment_complete")
     */
    public function completeAction(Order $order)
    {
    	$instruction = $order->getPaymentInstruction();
    	if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
    		$payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
    	} else {
    		$payment = $pendingTransaction->getPayment();
    	}
    
    	$result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
    	if (Result::STATUS_PENDING === $result->getStatus()) {
    		$ex = $result->getPluginException();
    
    		if ($ex instanceof ActionRequiredException) {
    			$action = $ex->getAction();
    
    			if ($action instanceof VisitUrl) {
    				return new RedirectResponse($action->getUrl());
    			}
    
    			throw $ex;
    		}
    	} else if (Result::STATUS_SUCCESS !== $result->getStatus()) {
    		throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
    	}
    	die('successful');
    
    	// payment was successful, do something interesting with the order
    }

    /** @DI\LookupMethod("form.factory") */
    protected function getFormFactory() { }
}
