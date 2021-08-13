<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\PropertyGuesser;

use PHPUnit\Framework\TestCase;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\IdPropertyGuesser;
use RichCongress\FixtureTestBundle\Exception\SkipPropertyConfigurationGuessingException;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;

/**
 * Class DateUpdatePropertyGuesserTest.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\AbstractPropertyConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\IdPropertyGuesser
 */
final class IdPropertyGuesserTest extends TestCase
{
    public function testNotSupported(): void
    {
        $guesser = new IdPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'username');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertFalse($isSupported);
    }

    public function testSupportAndGuess(): void
    {
        $guesser = new IdPropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'id');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertTrue($isSupported);

        $this->expectException(SkipPropertyConfigurationGuessingException::class);
        $guesser->guess($reflectionProperty, $context);
    }
}
