<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new cspoo\Swiftmailer\MailgunBundle\cspooSwiftmailerMailgunBundle(),

            // Aisel bundles
            new Aisel\UserBundle\AiselUserBundle(),
            new Aisel\PageBundle\AiselPageBundle(),
            new Aisel\ReviewBundle\AiselReviewBundle(),
            new Aisel\SearchBundle\AiselSearchBundle(),
            new Aisel\ProductBundle\AiselProductBundle(),
            new Aisel\MediaBundle\AiselMediaBundle(),
            new Aisel\CartBundle\AiselCartBundle(),
            new Aisel\OrderBundle\AiselOrderBundle(),
            new Aisel\NavigationBundle\AiselNavigationBundle(),
            new Aisel\AddressingBundle\AiselAddressingBundle(),
            new Aisel\ContactBundle\AiselContactBundle(),
            new Aisel\ConfigBundle\AiselConfigBundle(),
            new Aisel\SitemapBundle\AiselSitemapBundle(),
            new Aisel\NodeBundle\AiselNodeBundle(),
            new Aisel\ResourceBundle\AiselResourceBundle(),
            new Aisel\FixtureBundle\AiselFixtureBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->environment;
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }
}
