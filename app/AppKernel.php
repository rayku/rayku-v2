<?php

use Vespolina\Payment\StripeBundle\VespolinaPaymentStripeBundle;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function init()
    {
        // Please read http://symfony.com/doc/2.0/book/installation.html#configuration-and-setup
        umask(0000);

        parent::init();
    }

    public function registerBundles()
    {
        $bundles = array(
            // SYMFONY STANDARD EDITION
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        	new Jmikola\AutoLoginBundle\JmikolaAutoLoginBundle(),
        	new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
        	new Vespolina\Payment\StripeBundle\VespolinaPaymentStripeBundle(),
        		
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
        	new JMS\DiExtraBundle\JMSDiExtraBundle($this),
        	new JMS\SerializerBundle\JMSSerializerBundle($this),
        	new JMS\Payment\CoreBundle\JMSPaymentCoreBundle(),
        	new JMS\Payment\PaypalBundle\JMSPaymentPaypalBundle(),

            // DOCTRINE
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            // KNP HELPER BUNDLES
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),

            // FOS
            new FOS\UserBundle\FOSUserBundle(),
        	new FOS\RestBundle\FOSRestBundle(),
        	new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
        	new FOS\MessageBundle\FOSMessageBundle(),
        		
        	// SONATA
        	new Sonata\BlockBundle\SonataBlockBundle(),
        	new Sonata\jQueryBundle\SonatajQueryBundle(),
        	new Sonata\AdminBundle\SonataAdminBundle(),
        	new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
        	new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),

            // Enable this if you want to audit backend action
            new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(),
        	
        	// Rayku
            new Rayku\PageBundle\RaykuPageBundle(),
            new Rayku\ApiBundle\RaykuApiBundle(),
        	new Rayku\UserBundle\RaykuUserBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Bazinga\Bundle\FakerBundle\BazingaFakerBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
    
    public function getCacheDir()
    {
    	if($this->getEnvironment() !== 'prod'){
	    	return '/tmp/cache/rayku/'.$this->environment;
    	}else{
    		return parent::getCacheDir();
    	}
    }
    
    public function getLogDir()
    {
    	return '/var/log/rayku';
    }
}
