<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

class TextPropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    /** @var int */
    protected static $priority = -110;

    public function guess(\ReflectionProperty $reflectionProperty, Context $context): string
    {
        return $this->useFakerFormatter($context, 'text', 50);
    }

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool
    {
        $type = self::resolvePropertyType($reflectionProperty);

        return $type === 'string';
    }
}
