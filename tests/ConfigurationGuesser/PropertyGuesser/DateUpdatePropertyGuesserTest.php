<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\PropertyGuesser;

use PHPUnit\Framework\TestCase;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\DateUpdatePropertyGuesser;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;

/**
 * Class DateUpdatePropertyGuesserTest.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\AbstractPropertyConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\DateUpdatePropertyGuesser
 */
final class DateUpdatePropertyGuesserTest extends TestCase
{
    public function testNotSupported(): void
    {
        $guesser = new DateUpdatePropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'dateAdd');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertFalse($isSupported);
    }

    public function testSupportAndGuess(): void
    {
        $guesser = new DateUpdatePropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'dateUpdate');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertTrue($isSupported);

        $priority = $guesser->getPriority();
        self::assertEquals(-49, $priority);

        $configuration = $guesser->guess($reflectionProperty, $context);
        self::assertEquals('<dateTimeBetween($dateAdd, "now")>', $configuration);
    }
}
