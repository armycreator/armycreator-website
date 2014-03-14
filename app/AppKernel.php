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
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new APY\BreadcrumbTrailBundle\APYBreadcrumbTrailBundle(),
            new M6Web\Bundle\StatsdBundle\M6WebStatsdBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new FM\BbcodeBundle\FMBbcodeBundle(),
            new Oneup\AclBundle\OneupAclBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),

            new Sitioweb\Bundle\ArmyCreatorBundle\SitiowebArmyCreatorBundle(),
            new Sitioweb\Bundle\ArmyCreatorImportBundle\SitiowebArmyCreatorImportBundle(),
            new Sitioweb\Bundle\ExternalJsBundle\SitiowebExternalJsBundle(),
            new Sitioweb\Bundle\DiceBundle\SitiowebDiceBundle(),
            new Sitioweb\Bundle\AclBundle\SitiowebAclBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
			$bundles[] = new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle();
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
