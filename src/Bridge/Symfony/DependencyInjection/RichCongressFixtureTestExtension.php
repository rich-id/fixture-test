<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Bridge\Symfony\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractExtension;
use RichCongress\FixtureTestBundle\Bridge\Symfony\DependencyInjection\CompilerPass\ClassConfigurationGuessersCompilerPass;
use RichCongress\FixtureTestBundle\Bridge\Symfony\DependencyInjection\CompilerPass\PropertyConfigurationGuessersCompilerPass;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\ClassConfigurationGuesserInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\DefaultClassConfigurationGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\PropertyConfigurationGuesserInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

final class RichCongressFixtureTestExtension extends AbstractExtension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources'));
        $loader->load('services.xml');

        $container->registerForAutoconfiguration(ClassConfigurationGuesserInterface::class)
            ->addTag(ClassConfigurationGuessersCompilerPass::TAG);

        $container->registerForAutoconfiguration(PropertyConfigurationGuesserInterface::class)
            ->addTag(PropertyConfigurationGuessersCompilerPass::TAG);

        $registry = new Reference(ConfigurationGuesserRegistryInterface::class);
        $container->findDefinition(DefaultClassConfigurationGuesser::class)
            ->addMethodCall('setConfigurationGuesserRegistry', [$registry]);
    }
}
