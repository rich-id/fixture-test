<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\DefaultClassConfigurationGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistry;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;

/**
 * Class ConfigurationGuesserRegistryFactory
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class ConfigurationGuesserRegistryFactory implements ConfigurationGuesserRegistryFactoryInterface
{
    /** @var string[] */
    protected static $classConfigurationGuessers = [
        DefaultClassConfigurationGuesser::class,
    ];

    /** @var string[] */
    protected static $propertyConfigurationGuessers = [

    ];

    public function create(): ConfigurationGuesserRegistryInterface
    {
        $registry = new ConfigurationGuesserRegistry();

        foreach (static::$classConfigurationGuessers as $guesserClass) {
            $guesser = new $guesserClass();
            $guesser->setConfigurationGuesserRegistry($registry);
            $registry->addClassConfigurationGuesser($guesser);
        }

        foreach (static::$propertyConfigurationGuessers as $guesserClass) {
            $guesser = new $guesserClass();
            $guesser->setConfigurationGuesserRegistry($registry);
            $registry->addPropertyConfigurationGuesser($guesser);
        }

        return $registry;
    }
}
