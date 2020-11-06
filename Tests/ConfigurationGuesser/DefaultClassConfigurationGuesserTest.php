<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory\ConfigurationGuesserRegistryFactory;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * ClassGuesser DefaultClassConfigurationGuesserTest
 *
 * @package    RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\DefaultClassConfigurationGuesser
 */
final class DefaultClassConfigurationGuesserTest extends TestCase
{
    public function testGuessDummyUser(): void
    {
        $registry = ConfigurationGuesserRegistryFactory::createRegistry();
        $reflectionClass = new \ReflectionClass(DummyUser::class);
        $guesser = $registry->getClassConfigurationGuesser($reflectionClass);
        $configuration = $guesser->guess($reflectionClass);

        self::assertEquals(
            [
                'email'      => '<email()>',
                'username'   => '<username()>',
                'dateAdd'    => '<dateTimeBetween("-200 days", "now")>',
                'dateUpdate' => '<dateTimeBetween($dateAdd, "now")>',
            ],
            $configuration
        );
    }
}
