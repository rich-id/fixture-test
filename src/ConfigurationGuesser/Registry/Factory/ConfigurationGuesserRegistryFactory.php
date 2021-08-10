<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\DefaultClassConfigurationGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\BooleanPropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\DateTimePropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\DateUpdatePropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\FakerFormatterNamePropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\FloatPropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\IdPropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\IntegerPropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\TextPropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistry;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;

/**
 * Class ConfigurationGuesserRegistryFactory.
 *
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
        BooleanPropertyGuesser::class,
        DateTimePropertyGuesser::class,
        DateUpdatePropertyGuesser::class,
        FakerFormatterNamePropertyGuesser::class,
        FloatPropertyGuesser::class,
        IdPropertyGuesser::class,
        IntegerPropertyGuesser::class,
        TextPropertyGuesser::class,
    ];

    public function create(string $lang = 'en_UK'): ConfigurationGuesserRegistryInterface
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

    public static function createRegistry(): ConfigurationGuesserRegistryInterface
    {
        $factory = new static();

        return $factory->create();
    }
}
