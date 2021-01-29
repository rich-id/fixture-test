<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ConfigurationGuesserInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

/**
 * Interface ClassConfigurationGuesserInterface
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface ClassConfigurationGuesserInterface extends ConfigurationGuesserInterface
{
    public function guess(\ReflectionClass $reflectionClass, Context $context): array;
    public function supports(\ReflectionClass $reflectionClass, Context $context): bool;
}
