<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Exception;

class SkipPropertyConfigurationGuessingException extends \LogicException
{
    /** @var \ReflectionProperty */
    protected $reflectionProperty;

    public function __construct(\ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;
        $message = 'The property "' . $reflectionProperty->getName() . '" is skipped.';

        parent::__construct($message);
    }

    public function getReflectionProperty(): \ReflectionProperty
    {
        return $this->reflectionProperty;
    }
}
