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

            // Birgit - Component
            new Birgit\Component\Task\Bundle\Bundle\BirgitComponentTaskBundle(),
            new Birgit\Component\Task\Bundle\DoctrineBundle\BirgitComponentTaskDoctrineBundle(),
            new Birgit\Component\Type\Bundle\Bundle\BirgitComponentTypeBundle(),
            new Birgit\Component\Event\Bundle\Bundle\BirgitComponentEventBundle(),
            new Birgit\Component\Event\Bundle\DoctrineBundle\BirgitComponentEventDoctrineBundle(),

            // Birgit - Core
            new Birgit\Core\Bundle\Bundle\BirgitCoreBundle(),
            new Birgit\Core\Bundle\DoctrineBundle\BirgitCoreDoctrineBundle(),

            // Birgit - Base
            new Birgit\Base\Cron\Bundle\Bundle\BirgitBaseCronBundle(),
            new Birgit\Base\Git\Bundle\Bundle\BirgitBaseGitBundle(),
            new Birgit\Base\Local\Bundle\Bundle\BirgitBaseLocalBundle(),

            // Birgit - Api
            new Birgit\Api\Bundle\Bundle\BirgitApiBundle(),

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

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        if (isset($_SERVER['SYMFONY__VAGRANT']) && $_SERVER['SYMFONY__VAGRANT']) {
            return $this->rootDir.'/../../cache/'.$this->environment;
        }

        return parent::getCacheDir();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        if (isset($_SERVER['SYMFONY__VAGRANT']) && $_SERVER['SYMFONY__VAGRANT']) {
            return $this->rootDir.'/../../logs';
        }

        return parent::getLogDir();
    }
}
