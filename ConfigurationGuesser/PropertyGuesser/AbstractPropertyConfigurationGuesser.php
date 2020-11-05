<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

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
}
