<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassConfigurationGuesser;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * ClassGuesser ClassConfigurationGuesserTest
 *
 * @package    RichCongress\FixtureTestBundle\Tests\ConfigurationGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\ConfigurationGuesser\DefaultClassConfigurationGuesser
 */
final class ClassConfigurationGuesserTest extends TestCase
{
    public function testGuessDummyUser(): void
    {
        $guesser = new ClassConfigurationGuesser();
        $configuration = $guesser->guess(DummyUser::class);

        self::assertEquals(
            [
                'email'      => '<email()>',
                'username'   => '<username()>',
                'password'   => '',
                'dateAdd'    => '<dateTimeBetween("-200 days", "now")>',
                'dateUpdate' => '<dateTimeBetween($dateAdd, "now")>',
            ],
            $configuration
        );
    }
}
