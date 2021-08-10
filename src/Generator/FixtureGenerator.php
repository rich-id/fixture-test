<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Generator;

use Nelmio\Alice\DataLoaderInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory\ConfigurationGuesserRegistryFactory;
use RichCongress\FixtureTestBundle\Loader\CustomLoader;

class FixtureGenerator implements GeneratorInterface
{
    /** @var ConfigurationGuesserRegistryInterface */
    protected $configurationGuesserRegistry;

    /** @var Context */
    protected $context;

    /** @var DataLoaderInterface */
    protected $dataLoader;

    public function __construct(
        ConfigurationGuesserRegistryInterface $configurationGuesserRegistry = null,
        DataLoaderInterface $dataLoader = null
    ) {
        if ($configurationGuesserRegistry === null) {
            $factory = new ConfigurationGuesserRegistryFactory();
            $configurationGuesserRegistry = $factory->create();
        }

        $this->configurationGuesserRegistry = $configurationGuesserRegistry;
        $this->context = new Context();
        $this->dataLoader = $dataLoader ?? new CustomLoader();
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

    public function setLocale(string $language): self
    {
        $this->context->set(Context::LOCALE, $language);

        return $this;
    }

    /** @return object */
    public static function make(string $class, array $parameters = [])
    {
        $generator = new static();

        return $generator->generate($class, $parameters);
    }
}
