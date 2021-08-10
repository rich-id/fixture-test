<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ConfigurationGuesserInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

/**
 * Interface PropertyConfigurationGuesserInterface.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface PropertyConfigurationGuesserInterface extends ConfigurationGuesserInterface
{
    public function guess(\ReflectionProperty $reflectionProperty, Context $context);

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool;
}
