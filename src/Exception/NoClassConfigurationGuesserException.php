<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Exception;

class NoClassConfigurationGuesserException extends \LogicException
{
    /** @var \ReflectionClass */
    protected $reflectionClass;

    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
        $message = 'No class configuration guesser found for the class' . $reflectionClass->getName();

        parent::__construct($message);
    }

    public function getReflectionClass(): \ReflectionClass
    {
        return $this->reflectionClass;
    }
}
