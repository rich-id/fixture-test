<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\ClassConfigurationGuesserInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\PropertyConfigurationGuesserInterface;

/**
 * Class ConfigurationGuesserRegistryFactoryInterface
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface ConfigurationGuesserRegistryInterface
{
    public function getClassConfigurationGuesser(\ReflectionClass $class, Context $context): ClassConfigurationGuesserInterface;
    public function getPropertyConfigurationGuesser(\ReflectionProperty $property, Context $context): PropertyConfigurationGuesserInterface;
}
