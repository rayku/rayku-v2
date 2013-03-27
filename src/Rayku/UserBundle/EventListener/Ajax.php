<?php 

namespace Rayku\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;

class Ajax
{
	protected $template;
	
	public function __construct($template)
	{
		$this->template = $template;
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
			$return['success'] = true;
			
			$response = new Response(json_encode($return));
			$response->headers->set('Content-Type', 'application/json');
			
			$results = $event->getControllerResult();
			
			foreach($results as $result){
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
				}
			}
			$response->setContent(json_encode($return));
			$event->setResponse($response);
		}
	}
}