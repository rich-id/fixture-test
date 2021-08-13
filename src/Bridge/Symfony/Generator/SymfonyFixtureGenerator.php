<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Bridge\Symfony\Generator;

use Nelmio\Alice\DataLoaderInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;
use RichCongress\FixtureTestBundle\Generator\GeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SymfonyFixtureGenerator implements GeneratorInterface
{
    /** @var ConfigurationGuesserRegistryInterface */
    protected $configurationGuesserRegistry;

    /** @var Context */
    protected $context;

    /** @var DataLoaderInterface */
    protected $dataLoader;

    public function __construct(
        ConfigurationGuesserRegistryInterface $configurationGuesserRegistry,
        DataLoaderInterface $dataLoader,
        ParameterBagInterface $parameterBag
    ) {
        $this->configurationGuesserRegistry = $configurationGuesserRegistry;
        $this->context = new Context();
        $this->dataLoader = $dataLoader;

        $locale = $parameterBag->get('kernel.default_locale');
        $this->context->set(Context::LOCALE, $locale);
    }

    /** @return object */
    public function generate(string $class, array $parameters = [])
    {
        $reflectionClass = new \ReflectionClass($class);
        $guesser = $this->configurationGuesserRegistry->getClassConfigurationGuesser($reflectionClass, $this->context);
        $guessedConfig = $guesser->guess($reflectionClass, $this->context);
        $configuration = \array_merge($guessedConfig, $parameters);

        $objectSet = $this->dataLoader->loadData(
            [
                $class => [
                    'object' => $configuration,
                ],
            ]
        );

        return $objectSet->getObjects()['object'];
    }
}
