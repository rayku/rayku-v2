<?php

namespace Rayku\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class RegistrationFormHandler extends BaseHandler
{
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
	 * Amount to reward the referrer
	 * @var unknown
	 */
	protected $referralRefererReward;
	
	/**
	 * Amount to reward the referral
	 * @var unknown
	 */
	protected $referralreferralReward;
	
	protected $em;

    public function __construct(
        FormInterface $form,
        Request $request,
        UserManagerInterface $userManager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator,
    	$em,
        $referralCodeCookieParamName,
        $referralIpAddressCookieParamName,
        $referralDateCookieParamName,
        $referralRefererCookieParamName,
    	$referralRefererReward,
    	$referralreferralReward
    ) {
        parent::__construct($form, $request, $userManager, $mailer, $tokenGenerator);
        $this->referralCodeCookieParamName = $referralCodeCookieParamName;
        $this->referralIpAddressCookieParamName = $referralIpAddressCookieParamName;
        $this->referralDateCookieParamName = $referralDateCookieParamName;
        $this->referralRefererCookieParamName = $referralRefererCookieParamName;
        $this->referralRefererReward = $referralRefererReward;
        $this->referralReferralReward = $referralreferralReward;
        $this->em = $em;
    }

	protected function onSuccess(UserInterface $user, $confirmation)
	{
		if($user instanceof \Rayku\ApiBundle\Entity\User){
			// Setting parent user
			$referralCode = $this->request->cookies->get($this->referralCodeCookieParamName);

			if(false == is_null($referralCode)){
				$parentUser = $this->userManager->findUserBy(array("referral_code" => $referralCode));
				if(false == is_null($parentUser)){
					$parentUser->setPoints($parentUser->getPoints() + $this->referralRefererReward);
					$this->em->persist($parentUser);
					
					$user->setReferralReferer($parentUser);

					// Setting referral IP
					$referralIpAddress = $this->request->cookies->get($this->referralIpAddressCookieParamName, "");
					$user->setReferralIpAddress($referralIpAddress);

					// Setting referral DateTime
					$referralDate = new \DateTime();
					$referralDate->setTimestamp($this->request->cookies->getInt($this->referralDateCookieParamName, 0));
					$user->setReferralDate($referralDate);
					
					$user->setPoints($user->getPoints() + $this->referralReferralReward);
				}
			}
		}
		parent::onSuccess($user, $confirmation);
	}
}