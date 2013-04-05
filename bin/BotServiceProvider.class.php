<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Guzzle\Http\Client;

/**
 * Probably "temporary" class that will help us transition
 * from current "rotten" way to more civilized way of calling any API
 *
 * I'll put this class in all places where currently we are using file_get_content
 *
 * Extracted base urls of currently existing calls:
 * facebook.rayku.com - facebook bot
 * notification-bot.rayku.com - mac notification bot server
 * www.rayku.com:8892 - gtalk bot
 *
 * You can define your local instances by defining self::$bots - see commented definitions
 * 
 * @todo - we should handle cases when any of bot services is not available
 * @todo - refactorings:
 *  * abstract out common InternetMessagingService PHP library
 *  * it should be easy to use in any PHP project - let's not tie it strictly to symfony1.2
 *  * define common interface for different IMs that will define what we can ask any bot for
 *  * library will be responsible for talking with our bot services
 *  * lets use DI to allow easy creation of a class which represents a bot that we currently want to ask for something
 *  * lets handle TCP/HTTP communication in separate set of classes and use CURL
 *  ** it should handle cases when any service is not available at the moment
 * 
 * @author lukas
 */
class BotServiceProvider
{
    private $url;

    /**
     * Definition of all available bots
     * @todo - move this to app.yml or somewhere else outside this class - look out for cronjobs/* because they don't have direct access to app.yml content
     */

    
    private $logging = true;
    private $logFilePath = '/tmp/botServiceProvider.log';
            
    private $curlConnectTimeout = 1;
    private $curlTimeout = 5;
    
    /**
     * Default state of enabled flag
     */
    private $enabled = true;
    
    /**
     * If you pass only $url it will be used directly - without any modifications
     * However if you pass $botId then $url should be just the Path + Query part of URL
     * Final URL is builded from serviceURL for given BOT and Query you've passed here
     *
     */
    function __construct($url, $botId = null)
    {
        $this->url = $url;
        $this->botId = $botId;
    }
    
    function disable()
    {
        $this->enabled = false;
    }

    function getContent()
    {
        if (!$this->enabled) {
            return json_encode(array());
        }
        
        $time = time();
        $url = $this->getUrl();
        
        $client = new Client($url);
        $request = $client->get($url);
        $request->getCurlOptions()->set(CURLOPT_CONNECTTIMEOUT, $this->curlConnectTimeout);
        $request->getCurlOptions()->set(CURLOPT_TIMEOUT, $this->curlTimeout);
        try {
            $response = $request->send();
        } catch(\Guzzle\Http\Exception\BadResponseException $e) {
            if ($this->logging) {
                file_put_contents(
                    $this->logFilePath,
                    'time: '
                        . (time()-$time)
                        . ', url: '.$url
                        . ', exception: '.$e->getMessage()
                        ."\n",
                    FILE_APPEND
                );
            }	
            return '[]';
        }
         
        $content = $response->getBody(true);
     	 
        if ($this->logging) {
            file_put_contents(
                $this->logFilePath,
                'time: '
                    . (time()-$time)
                    . ', url: '.$url
                    . ', response: '.$content
                    ."\n",
                FILE_APPEND
            );
        }
        return $content;
    }

    function getUrl()
    {

        $bots = array(
            'gtalk' => array(
                'prefix' => 'http://qa.rayku.com:8892',
                'serviceUrl' => 'http://bots.rayku.com:8892',
                'enabled' => true
            ),
        );

        if ($this->botId) {
            return $bots[$this->botId]['serviceUrl'] . $this->url;
        } else {
		
            return $this->url;
        }
    }

    /**
     * @return BotServiceProvider
     */
    static function createFor($url)
    {
    	//return new self('127.0.0.1');

        $bots = array(
            'gtalk' => array(
                'prefix' => 'http://qa.rayku.com:8892',
                'serviceUrl' => 'http://bots.rayku.com:8892',
                'enabled' => true
            ),
        );
    	
        foreach ($bots as $botId => $botParams) {
            if (is_numeric(strpos($url, $botParams['prefix']))) {
                $botService = new self(
                    str_replace($botParams['prefix'], '', $url),
                    $botId
                );
                if (!$botParams['enabled']) {
                    $botService->disable();
                }
                
                return $botService;
            }
        }
        return new self($url);
    }
}

?>

