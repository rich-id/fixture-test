<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\Exception\SkipPropertyConfigurationGuessingException;

/**
 * Class IdPropertyGuesser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class IdPropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    protected static $priority = 100;

    public function guess(\ReflectionProperty $reflectionProperty, Context $context): ?int
    {
        throw new SkipPropertyConfigurationGuessingException($reflectionProperty);
    }

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool
    {
        return $reflectionProperty->getName() === 'id';
    }
}
