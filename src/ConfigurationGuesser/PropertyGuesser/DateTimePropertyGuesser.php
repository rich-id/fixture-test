<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

class DateTimePropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    /** @var int */
    protected static $priority = -50;

    /** @var string */
    protected static $lowerBound = '"-200 days"';

    /** @var string */
    protected static $higherBound = '"now"';

    public function guess(\ReflectionProperty $reflectionProperty, Context $context): string
    {
        return $this->useFakerFormatter(
            $context,
            'dateTimeBetween',
            static::$lowerBound,
            static::$higherBound
        );
    }

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool
    {
        $type = self::resolvePropertyType($reflectionProperty);

        return $type === \DateTime::class;
    }
}
