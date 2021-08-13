<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Bridge\Symfony\DependencyInjection\CompilerPass;

use RichCongress\BundleToolbox\Configuration\AbstractCompilerPass;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistry;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ClassConfigurationGuessersCompilerPass extends AbstractCompilerPass
{
    public const TAG = 'fixture_test.class_guesser';

    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition(ConfigurationGuesserRegistry::class);
        $services = self::getReferencesByTag($container, self::TAG);

        foreach ($services as $service) {
            $definition->addMethodCall('addClassConfigurationGuesser', [$service]);
        }
    }

    /** @return Reference[] */
    protected static function getReferencesByTag(ContainerBuilder $container, string $tag): array
    {
        $serviceConfigs = $container->findTaggedServiceIds($tag);
        $serviceIds = \array_keys($serviceConfigs);

        return \array_map(
            static function (string $serviceId): Reference {
                return new Reference($serviceId);
            },
            $serviceIds
        );
    }
}
