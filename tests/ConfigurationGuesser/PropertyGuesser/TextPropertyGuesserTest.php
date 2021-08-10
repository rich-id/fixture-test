<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\FakerFormatterNamePropertyGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\TextPropertyGuesser;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\AbstractPropertyConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\TextPropertyGuesser
 */
final class TextPropertyGuesserTest extends TestCase
{
    public function testNotSupported(): void
    {
        $guesser = new TextPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'anyInt');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertFalse($isSupported);
    }

    public function testNotSupportedWithoutType(): void
    {
        $guesser = new TextPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'untypedProperty');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertFalse($isSupported);
    }

    public function testSupportedButPriorityLessThanAnotherPropertyGuesser(): void
    {
        $guesser = new TextPropertyGuesser();
        $anotherGuesser = new FakerFormatterNamePropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'username');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertTrue($isSupported);
        self::assertLessThan($anotherGuesser->getPriority(), $guesser->getPriority());
    }

    public function testSupportAndGuess(): void
    {
        $guesser = new TextPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'anyString');
        $context = new Context([Context::LOCALE => 'fr_FR']);

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertTrue($isSupported);

        $configuration = $guesser->guess($reflectionProperty, $context);
        self::assertEquals('<fr_FR:text(50)>', $configuration);
    }
}
