<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\PropertyGuesser;

use PHPUnit\Framework\TestCase;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\DateTimePropertyGuesser;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;

/**
 * Class DateTimePropertyGuesserTest.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\Internal\CachedGetterTrait;
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\AbstractPropertyConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\DateTimePropertyGuesser
 */
final class DateTimePropertyGuesserTest extends TestCase
{
    public function testNotSupported(): void
    {
        $guesser = new DateTimePropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'username');
        $context = new Context();

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertFalse($isSupported);
    }

    public function testSupportAndGuess(): void
    {
        $guesser = new DateTimePropertyGuesser();
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'dateAdd');
        $context = new Context([Context::LOCALE => 'fr_FR']);

        $isSupported = $guesser->supports($reflectionProperty, $context);
        self::assertTrue($isSupported);

        $configuration = $guesser->guess($reflectionProperty, $context);
        self::assertEquals('<fr_FR:dateTimeBetween("-200 days", "now")>', $configuration);
    }
}
