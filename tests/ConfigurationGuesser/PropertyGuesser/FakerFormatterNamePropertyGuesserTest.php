<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\PropertyGuesser;

use PHPUnit\Framework\TestCase;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\FakerFormatterNamePropertyGuesser;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;

/**
 * Class FakerFormatterNamePropertyGuesserTest.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\AbstractPropertyConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\FakerFormatterNamePropertyGuesser
 */
final class FakerFormatterNamePropertyGuesserTest extends TestCase
{
    /** @var FakerFormatterNamePropertyGuesser */
    private $guesser;

    /** @var Context */
    private $context;

    public function setUp(): void
    {
        parent::setUp();

        $this->guesser = new FakerFormatterNamePropertyGuesser();
        $this->context = new Context();
    }

    public function testSupportAndGuessUsername(): void
    {
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'username');
        $isSupported = $this->guesser->supports($reflectionProperty, $this->context);
        $priority = $this->guesser->getPriority();
        self::assertTrue($isSupported);
        self::assertEquals(-100, $priority);

        $configuration = $this->guesser->guess($reflectionProperty, $this->context);
        self::assertEquals('<username()>', $configuration);
    }

    public function testNoSupportAndNoGuessUsername(): void
    {
        $reflectionProperty = new \ReflectionProperty(DummyUser::class, 'anyArray');
        $isSupported = $this->guesser->supports($reflectionProperty, $this->context);
        self::assertFalse($isSupported);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('No formatter found');
        $this->guesser->guess($reflectionProperty, $this->context);
    }
}
