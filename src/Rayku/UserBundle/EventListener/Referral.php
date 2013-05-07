<?php

namespace Rayku\UserBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\HttpKernel;
use FOS\UserBundle\Model\UserManagerInterface;

class Referral
{
	/**
	 * Name of the referral code query parameter in the URI
	 * @var string
	 */
	protected $referralCodeQueryParamName = "ref";
	
	/**
	 * Name of the cookie param that stores referral code
	 * @var string
	 */
	protected $referralCodeCookieParamName = "ref_code";
	
	/**
	 * Name of the cookie param that stores visitors ip-address
	 * @var string
	 */
	protected $referralIpAddressCookieParamName = "ref_ip";
	
	/**
	 * Name of the cookie param that stores referral uri visit date and time
	 * @var string
	 */
	protected $referralDateCookieParamName = "ref_date";
	
	/**
	 * Name of the cookie param that stores referer
	 * @var string
	 */
	protected $referralRefererCookieParamName = "ref_referer";
	
	/**
	 * UserManager instance, used to check referralCode validity     *
	 * @var UserManagerInterface
	 */
	protected $userManager;
	
	function __construct(
			$referralCodeQueryParamName,
			$referralCodeCookieParamName,
			$referralIpAddressCookieParamName,
			$referralDateCookieParamName,
			$referralRefererCookieParamName,
			UserManagerInterface $userManager
	) {
		$this->referralCodeQueryParamName = $referralCodeQueryParamName;
		$this->referralCodeCookieParamName = $referralCodeCookieParamName;
		$this->referralIpAddressCookieParamName = $referralIpAddressCookieParamName;
		$this->referralDateCookieParamName = $referralDateCookieParamName;
		$this->referralRefererCookieParamName = $referralRefererCookieParamName;
		$this->userManager = $userManager;
	}
	
	/**
	 * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		if(HttpKernel::MASTER_REQUEST != $event->getRequestType()){
			return true;
		}
	
		$request = $event->getRequest();
	
		$referralCode = $request->query->get($this->referralCodeQueryParamName);
	
		if(is_null($referralCode)){
			return true;
		}
	
		//TODO: It can be possible to implement more "light" referralCode checking without full user data retrieving on success
		$parentUser = $this->userManager->findUserBy(array("referral_code" => $referralCode));
		if(is_null($parentUser))
		{
			return true;
		}
	
		$referralIpAddress = $request->getClientIp();
		$referralDate = new \DateTime();
		$referralReferer = $request->headers->get('referer');
	
		$originalUri = $request->getRequestUri();
		$uriToRedirect = self::removeUriQueryParameter($originalUri, $this->referralCodeQueryParamName);
	
		$response = new RedirectResponse($uriToRedirect);
		$response->headers->setCookie(new Cookie($this->referralCodeCookieParamName, $referralCode, new \DateTime("+10 years")));
		$response->headers->setCookie(new Cookie($this->referralIpAddressCookieParamName, $referralIpAddress, new \DateTime("+10 years")));
		$response->headers->setCookie(new Cookie($this->referralDateCookieParamName, $referralDate->getTimestamp(), new \DateTime("+10 years")));
		$response->headers->setCookie(new Cookie($this->referralRefererCookieParamName, $referralReferer, new \DateTime("+10 years")));
	
		$event->setResponse($response);
	}
	
	/**
	 * Removes single query parameter from request URI
	 * @param $uri string Uri to remove query parameter to
	 * @param $paramName string Name of the parameter to remove
	 * @return string URI with required parameter removed
	 */
	static protected function removeUriQueryParameter($uri, $paramName)
	{
		$originalUriParts = parse_url($uri);
		parse_str($originalUriParts["query"], $originalUriQueryVars);
		unset($originalUriQueryVars[$paramName]);
		$newUriQueryVars = http_build_query($originalUriQueryVars);
	
		return $originalUriParts["path"] . '?' . $newUriQueryVars;
	}
}