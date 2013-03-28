<?php 

namespace Rayku\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;

class Ajax
{
	protected $serializer;
	
	public function __construct($kernel)
	{
		$this->serializer = $kernel->getContainer()->get('jms_serializer');
	}
	
	public function onKernelResponse($event)
	{
		if($event->getRequest()->isXmlHttpRequest()){
			$event->getResponse()->headers->set('Content-Type', 'application/json');
		}
	}
	
	public function onKernelView($event)
	{
		$request = $event->getRequest();
		
		if ($request->isXmlHttpRequest() && $request->getMethod() == 'POST') {
			$formError = false;
			$return['success'] = true;			
			$response = new Response();
			$response->headers->set('Content-Type', 'application/json');
			
			$results = $event->getControllerResult();
			
			foreach($results as $key => $result){
				if($result instanceof \Symfony\Component\Form\Form){
					foreach($result->getChildren() as $child){
						$error_message = $child->getErrorsAsString();
						if(!empty($error_message)){
							$formError = true;
							$event->stopPropagation();
							$return['success'] = false;
							$return['errors'][$child->createView()->get('id')] = $child->getErrorsAsString();
							$response->setStatusCode(400);
						}
					}
				}else{
					$return[$key] = $results;
				}
			}
			
			if($formError){
				$response->setContent($this->serializer->serialize($return, 'json'));
			}else{
				$response->setContent($this->serializer->serialize($results, 'json'));
			}
			$event->setResponse($response);
		}
	}
}