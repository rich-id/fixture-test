<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ConfigurationGuesserInterface;

/**
 * Interface PropertyConfigurationGuesserInterface
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface PropertyConfigurationGuesserInterface extends ConfigurationGuesserInterface
{
    public function guess(\ReflectionProperty $reflectionProperty);
    public function supports(\ReflectionProperty $reflectionProperty): bool;
}
