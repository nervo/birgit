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

            // Birgit - Core
            new Birgit\Core\Bundle\Bundle\BirgitCoreBundle(),
            new Birgit\Core\Bundle\DoctrineBundle\BirgitCoreDoctrineBundle(),

            // Birgit - Component
            new Birgit\Component\Task\Bundle\Bundle\BirgitComponentTaskBundle(),
            new Birgit\Component\Task\Bundle\DoctrineBundle\BirgitComponentTaskDoctrineBundle(),
            new Birgit\Component\Type\Bundle\Bundle\BirgitComponentTypeBundle(),

            // Birgit - Extra
            new Birgit\Extra\Cron\Bundle\Bundle\BirgitExtraCronBundle(),
            new Birgit\Extra\Git\Bundle\Bundle\BirgitExtraGitBundle(),
            new Birgit\Extra\Local\Bundle\Bundle\BirgitExtraLocalBundle(),

            // Birgit - Front
            new Birgit\Front\Bundle\Bundle\BirgitFrontBundle()
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();

            // Birgit - Test
            $bundles[] = new Birgit\Test\Bundle\Bundle\BirgitTestBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
