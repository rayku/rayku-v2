<?php 

namespace Rayku\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;

class Ajax
{
	protected $serializer;
	protected $translator;
	
	public function __construct($kernel, $translator)
	{
		$this->serializer = $kernel->getContainer()->get('jms_serializer');
		$this->translator = $translator;
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
		if (
			($request->getMethod() == 'POST' || $request->getMethod() == 'PATCH') &&
			($request->isXmlHttpRequest() || strpos($request->headers->get('referer'), '/api/doc') !== false)
		){
			$formError = false;
			$return['success'] = true;			
			$response = new Response();
			$response->headers->set('Content-Type', 'application/json');
			
			$results = $event->getControllerResult();
			
			foreach($results as $key => $result){
				if($key == 'success' && $result == false){
					$formError = true;
				}
				if($result instanceof \Symfony\Component\Form\Form){
					foreach($result->all() as $child){
						// @todo properly iterate subchildren
						if(array() !== $child->all()){
							$children = $child->all();
							$child = array_shift($children);
						}
						$errors = $child->getErrors();
						foreach($errors as $error){
							$formError = true;
							$event->stopPropagation();
							$return['success'] = false;
							$return['errors'][$child->createView()->get('id')] = $this->translator->trans($error->getMessage(), array(), 'validators');
						}
					}
				}else{
					$return[$key] = $results;
				}
			}
			if($formError){
				$response->setStatusCode(400);
				$response->setContent($this->serializer->serialize($return, 'json'));
			}else{
				$response->setContent($this->serializer->serialize($results, 'json'));
			}
			$event->setResponse($response);
		}
	}
}