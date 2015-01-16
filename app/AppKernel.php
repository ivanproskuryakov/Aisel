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
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Payum\Bundle\PayumBundle\PayumBundle(),

            // Sonata
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\jQueryBundle\SonatajQueryBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Iphp\FileStoreBundle\IphpFileStoreBundle(),

            // Aisel bundles
            new Aisel\FrontendUserBundle\AiselFrontendUserBundle(),
            new Aisel\BackendUserBundle\AiselBackendUserBundle(),
            new Aisel\AdminBundle\AiselAdminBundle(),
            new Aisel\PageBundle\AiselPageBundle(),
            new Aisel\CategoryBundle\AiselCategoryBundle(),
            new Aisel\SearchBundle\AiselSearchBundle(),
            new Aisel\ProductBundle\AiselProductBundle(),
            new Aisel\CartBundle\AiselCartBundle(),
            new Aisel\OrderBundle\AiselOrderBundle(),
            new Aisel\NavigationBundle\AiselNavigationBundle(),
            new Aisel\AddressingBundle\AiselAddressingBundle(),
            new Aisel\ContactBundle\AiselContactBundle(),
            new Aisel\ConfigBundle\AiselConfigBundle(),
            new Aisel\SettingsBundle\AiselSettingsBundle(),
            new Aisel\SitemapBundle\AiselSitemapBundle(),
            new Aisel\ResourceBundle\AiselResourceBundle(),
            new Aisel\InstallerBundle\AiselInstallerBundle(),
            new Aisel\FixtureBundle\AiselFixtureBundle(),

        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
