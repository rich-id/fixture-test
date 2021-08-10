<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Exception;

class NoPropertyConfigurationGuesserException extends \LogicException
{
    /** @var \ReflectionProperty */
    protected $reflectionProperty;

    public function __construct(\ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;
        $message = 'No property configuration guesser found for the property' . $reflectionProperty->getName();

        parent::__construct($message);
    }

    public function getReflectionProperty(): \ReflectionProperty
    {
        return $this->reflectionProperty;
    }
}
