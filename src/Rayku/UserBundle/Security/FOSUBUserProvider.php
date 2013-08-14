<?php
namespace Rayku\UserBundle\Security;
 
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
 
class FOSUBUserProvider extends BaseClass
{
 
    /**
     * {@inheritDoc}
     */
    public function connect($user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
 
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
 
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
 
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
 
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
 
        $this->userManager->updateUser($user);
    }
 
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        
        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';
            // create new user here
            
            
            $data = $response->getResponse();
            if($response->getResourceOwner()->getName() == 'facebook'){
	            $user = $this->userManager->findUserByEmail($data['email']);
            }else if($response->getResourceOwner()->getName() == 'linkedin'){
            	$user = $this->userManager->findUserByEmail($data['emailAddress']);
            }
            
            if(null === $user){
	            $user = $this->userManager->createUser();
	            $user->setPassword(md5(time().rand()));
	            if($response->getResourceOwner()->getName() == 'facebook'){
	            	$user = $this->facebookData($user, $data);
	            }else if($response->getResourceOwner()->getName() == 'linkedin'){
	            	$user = $this->linkedinData($user, $data);
	            }          
	            $duplicateUsername = $this->userManager->findUserBy(array('username' => $user->getUsername()));
	            if(!empty($duplicateUsername)){
	            	$user->setUsername($user->getUsername().rand(1,24));
	            	$duplicateUsername = $this->userManager->findUserBy(array('username' => $user->getUsername()));
	            }
            }
            $user->$setter_id($username);
            $user->$setter_token($response->getAccessToken());
            
            //I have set all requested data with the user's username
            //modify here with relevant data
		    
            $this->userManager->updateUser($user);
	        return $user;
        }
 
        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);
 
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
 
        //update access token
        $user->$setter($response->getAccessToken());
 
        return $user;
    }
    
    private function linkedinData($user, $data)
    {
    	$user->setEnabled(true);
    	if(isset($data['emailAddress'])) $user->setEmail($data['emailAddress']);
    	if(isset($data['formattedName'])){
    		$name = explode(" ", $data['formattedName']);
    		$user->setFirstName($name[0]);
    		$user->setLastName(array_pop($name));
    	}
    	if(isset($data['educations'])){
    		$user->setDegree($data['educations']['values'][0]['fieldOfStudy']);
    		$user->setSchool($data['educations']['values'][0]['schoolName']);
    	}
    	$user->setUsername($user->getFirstName().$user->getLastName());
    	
    	return $user;
    }
    
    private function facebookData($user, $data)
    {
    	$user->setEnabled(true);
    	if(isset($data['first_name'])) $user->setFirstName($data['first_name']);
    	if(isset($data['last_name'])) $user->setLastName($data['last_name']);
    	if(isset($data['username'])) $user->setUsername($data['username']);
    	if(isset($data['email'])) $user->setEmail($data['email']);
    	if(isset($data['education'])){
    		$education = array_pop($data['education']);
    		$user->setSchool($education['school']['name']);
    		$user->setDegree($education['degree']['name']);
    	}
    	return $user;
    }
 
}