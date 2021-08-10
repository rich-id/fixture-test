<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\IntegerPropertyGuesser;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\AbstractPropertyConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\IntegerPropertyGuesser
 */
final class IntegerPropertyGuesserTest extends TestCase
{
    public function testNotSupported(): void
    {
        $guesser = new IntegerPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'username');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertFalse($isSupported);
    }

    public function testSupportAndGuess(): void
    {
        $guesser = new IntegerPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'anyInt');
        $context = new Context([Context::LOCALE => 'fr_FR']);

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertTrue($isSupported);

        $configuration = $guesser->guess($reflectionProperty, $context);
        self::assertEquals('<fr_FR:randomNumber()>', $configuration);
    }
}
