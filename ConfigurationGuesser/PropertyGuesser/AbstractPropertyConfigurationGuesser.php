<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;

/**
 * Class AbstractPropertyConfigurationGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
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
        $function = sprintf('%s(%s)', $formatter, implode(', ', $parameters));

        if ($context->has(Context::LOCALE)) {
            return sprintf('<%s:%s>', $context->get(Context::LOCALE), $function);
        }

        return sprintf('<%s>', $function);
    }
}
