<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use PhpDocReader\PhpDocReader;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;

/**
 * Class AbstractPropertyConfigurationGuesser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
abstract class AbstractPropertyConfigurationGuesser implements PropertyConfigurationGuesserInterface
{
    /** @var int */
    protected static $priority = 0;

    /** @var ConfigurationGuesserRegistryInterface */
    protected $configurationGuesserRegistry;

    public function setConfigurationGuesserRegistry(ConfigurationGuesserRegistryInterface $configurationGuesserRegistry): void
    {
        $this->configurationGuesserRegistry = $configurationGuesserRegistry;
    }

    public function getPriority(): int
    {
        return static::$priority;
    }

    protected function useFakerFormatter(Context $context, string $formatter, ...$parameters): string
    {
        $function = \sprintf('%s(%s)', $formatter, \implode(', ', $parameters));

        if ($context->has(Context::LOCALE)) {
            return \sprintf('<%s:%s>', $context->get(Context::LOCALE), $function);
        }

        return \sprintf('<%s>', $function);
    }

    protected static function resolvePropertyType(\ReflectionProperty $reflectionProperty): ?string
    {
        if (\method_exists($reflectionProperty, 'getType')) {
            $reflectionType = $reflectionProperty->getType();
            $type = $reflectionType ? (string) $reflectionType : null;

            if ($type !== null) {
                return $type;
            }
        }

        $phpDocReader = new PhpDocReader();

        return $phpDocReader->getPropertyType($reflectionProperty);
    }
}
