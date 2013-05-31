<?php

namespace Rayku\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\SecurityExtraBundle\Annotation\SecureParam;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * RestMessage controller.
 */
class MessageController extends Controller
{

	/**
	 * Gets the provider service
	 *
	 * @return ProviderInterface
	 */
	protected function getProvider()
	{
		return $this->container->get('fos_message.provider');
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get the current user's inbox threads",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 */
	public function getThreadsAction()
	{
		return $this->getThreadsInboxAction();
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   description="Get the current user's inbox threads",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 */
	public function getThreadsInboxAction()
	{
		return array('thread' => $this->getProvider()->getInboxThreads());
	}

	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   description="Get the current user's sent threads",
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   }
	 * )
	 */
	public function getThreadsSentAction()
	{
		return array('thread' => $this->getProvider()->getSentThreads());
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful"
	 *   },
	 *   description="Get a thread",
	 *   output="Rayku\ApiBundle\Entity\Thread"
	 * )
	 */
	public function getThreadAction($threadId)
	{
		return array('thread' => $this->getProvider()->getThread($threadId));
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful",
	 *     403="Returned when the user is not authorized"
	 *   },
	 *   description="Delete a thread record"
	 * )
	 */
	public function deleteThreadAction($threadId)
	{
		$thread = $this->getProvider()->getThread($threadId);
		$this->container->get('fos_message.deleter')->markAsDeleted($thread);
		$this->container->get('fos_message.thread_manager')->saveThread($thread);
		
		return array('success' => true);
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful",
	 *     400="Returned when there is an error"
	 *   },
	 *   description="Create a new thread",
	 *   resource=true,
	 *   input="Rayku\ApiBundle\Form\NewThreadType"
	 * )
	 */
	public function postThreadsAction()
	{
		$form = $this->container->get('fos_message.new_thread_form.factory')->create();
		$formHandler = $this->container->get('fos_message.new_thread_form.handler');
		if ($message = $formHandler->process($form)) {
			return array(
				'success' => true,
				'thread' => $message->getThread()
			);
		}
		
		return array(
			'form' => $form
		);
	}
	
	/**
	 * @Secure(roles="ROLE_USER")
	 * @View()
	 * @ApiDoc(
	 *   statusCodes={
	 *     200="Returned when successful",
	 *     400="Returned when there is an error"
	 *   },
	 *   description="Reply to a thread",
	 *   input="Rayku\ApiBundle\Form\ReplyMessageType"
	 * )
	 */
	public function postThreadReplyAction($threadId)
	{
        $thread = $this->getProvider()->getThread($threadId);
        $form = $this->container->get('fos_message.reply_form.factory')->create($thread);
        $formHandler = $this->container->get('fos_message.reply_form.handler');

        if ($message = $formHandler->process($form)) {
            return array('thread' => $message->getThread());
        }

        return array(
            'form' => $form,
            'thread' => $thread
        );
	}
}

