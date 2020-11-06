<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\Generator;

use RichCongress\FixtureTestBundle\Generator\FixtureGenerator;
use RichCongress\FixtureTestBundle\Tests\Resources\Object\DummyUser;
use RichCongress\TestTools\TestCase\TestCase;

/**
 * ClassGuesser FixtureGeneratorTest
 *
 * @package    RichCongress\FixtureTestBundle\Tests\Generator
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\FixtureTestBundle\Generator\FixtureGenerator
 */
final class FixtureGeneratorTest extends TestCase
{
    public function testGenerationForUser(): void
    {
        $generator = new FixtureGenerator();
        /** @var DummyUser $user */
        $user = $generator->generate(DummyUser::class);

        self::assertInstanceOf(DummyUser::class, $user);
        self::assertNull($user->getId());
        self::assertMatchesRegularExpression('/(\w*)@(\w*).(\w*)/', $user->getEmail());
        self::assertNotNull($user->getUsername());
        self::assertNull($user->getPassword());
        self::assertLessThanOrEqual(
            $user->getDateUpdate(),
            $user->getDateAdd()
        );
    }

    public function testGenerationForUserWithForcedParameters(): void
    {
        $generator = new FixtureGenerator();
        /** @var DummyUser $user */
        $user = $generator->generate(DummyUser::class, [
            'id'       => 1,
            'password' => 'S3cret',
            'username' => 'john_doe',
        ]);

        self::assertInstanceOf(DummyUser::class, $user);
        self::assertEquals(1, $user->getId());
        self::assertMatchesRegularExpression('/(\w*)@(\w*).(\w*)/', $user->getEmail());
        self::assertEquals('john_doe', $user->getUsername());
        self::assertEquals('S3cret', $user->getPassword());
        self::assertLessThanOrEqual(
            $user->getDateUpdate(),
            $user->getDateAdd()
        );
    }
}
