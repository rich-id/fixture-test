<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser\ClassGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\DefaultClassConfigurationGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory\ConfigurationGuesserRegistryFactory;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;
use RichCongress\TestTools\Helper\ForceExecutionHelper;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * ClassGuesser DefaultClassConfigurationGuesserTest.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\AbstractClassConfigurationGuesser
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\DefaultClassConfigurationGuesser
 */
final class DefaultClassConfigurationGuesserTest extends TestCase
{
    /** @var DefaultClassConfigurationGuesser */
    private $guesser;

    /** @var Context */
    private $context;

    public function setUp(): void
    {
        parent::setUp();

        $registry = ConfigurationGuesserRegistryFactory::createRegistry();
        $this->context = new Context();
        $this->guesser = new DefaultClassConfigurationGuesser();
        $this->guesser->setConfigurationGuesserRegistry($registry);
    }

    public function testSupportAndPriority(): void
    {
        $reflectionClass = new \ReflectionClass(DummyUser::class);
        $isSupported = $this->guesser->supports($reflectionClass, $this->context);
        $priority = $this->guesser->getPriority();

        self::assertTrue($isSupported);
        self::assertEquals(-100, $priority);
    }

    public function testGuessDummyUser(): void
    {
        $reflectionClass = new \ReflectionClass(DummyUser::class);
        $configuration = $this->guesser->guess($reflectionClass, $this->context);

        self::assertEquals(
            [
                'email'      => '<email()>',
                'username'   => '<username()>',
                'dateAdd'    => '<dateTimeBetween("-200 days", "now")>',
                'dateUpdate' => '<dateTimeBetween($dateAdd, "now")>',
                'password'   => '<password()>',
            ],
            $configuration
        );
    }

    public function testGuessDummyUserWithLang(): void
    {
        $this->context->set(Context::LOCALE, 'fr_FR');
        $reflectionClass = new \ReflectionClass(DummyUser::class);
        $configuration = $this->guesser->guess($reflectionClass, $this->context);

        self::assertEquals(
            [
                'email'      => '<fr_FR:email()>',
                'username'   => '<fr_FR:username()>',
                'dateAdd'    => '<fr_FR:dateTimeBetween("-200 days", "now")>',
                'dateUpdate' => '<fr_FR:dateTimeBetween($dateAdd, "now")>',
                'password'   => '<fr_FR:password()>',
            ],
            $configuration
        );
    }

    public function testGuessDummyUserFromCache(): void
    {
        ForceExecutionHelper::setValue($this->guesser, 'guessesCache', [
            DummyUser::class => ['This is a cache'],
        ]);

        $reflectionClass = new \ReflectionClass(DummyUser::class);
        $configuration = $this->guesser->guess($reflectionClass, $this->context);

        self::assertEquals(
            ['This is a cache'],
            $configuration
        );
    }
}
