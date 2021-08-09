<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

/**
 * Class DateUpdatePropertyGuesser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class DateUpdatePropertyGuesser extends DateTimePropertyGuesser
{
    public function guess(\ReflectionProperty $reflectionProperty, Context $context): string
    {
        return $this->useFakerFormatter(
            $context,
            'dateTimeBetween',
            '$dateAdd',
            static::$higherBound
        );
    }

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool
    {
        return parent::supports($reflectionProperty, $context) && $reflectionProperty->getName() === 'dateUpdate';
    }

    public function getPriority(): int
    {
        return parent::getPriority() + 1;
    }
}
