<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

/**
 * Class DefaultClassConfigurationGuesser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class DefaultClassConfigurationGuesser extends AbstractClassConfigurationGuesser
{
    /** @var int */
    protected static $priority = -100;

    /** @var array<string, array<string, mixed>> */
    protected $guessesCache = [];

    public function guess(\ReflectionClass $reflectionClass, Context $context): array
    {
        $class = $reflectionClass->getName();

        if (!\array_key_exists($class, $this->guessesCache)) {
            $config = [];

            foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                $this->guessProperty($config, $reflectionProperty, $context->copy());
            }

            $this->guessesCache[$class] = $config;
        }

        return $this->guessesCache[$class];
    }

    public function supports(\ReflectionClass $reflectionClass, Context $context): bool
    {
        return true;
    }

    protected function guessProperty(array &$config, \ReflectionProperty $reflectionProperty, Context $context): void
    {
        $name = $reflectionProperty->getName();

        try {
            $guesser = $this->configurationGuesserRegistry->getPropertyConfigurationGuesser($reflectionProperty, $context);
            $value = $guesser->guess($reflectionProperty, $context);
            $config[$name] = $value;
        } catch (\LogicException $e) {
            // Skipped
        }
    }
}
