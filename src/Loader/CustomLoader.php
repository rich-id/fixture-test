<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Loader;

use Faker\Generator as FakerGenerator;
use Nelmio\Alice\Loader\NativeLoader;
use RichCongress\FixtureTestBundle\Internal\ForcePropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * ClassGuesser CustomLoader.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class CustomLoader extends NativeLoader
{
    /** @var int|null */
    protected static $count;

    public function __construct(FakerGenerator $fakerGenerator = null)
    {
        if (self::$count === null) {
            self::$count = (int) ($_ENV['SEED'] ?? \random_int(0, PHP_INT_MAX));
        }

        parent::__construct($fakerGenerator);
    }

    public function getSeed(): int
    {
        self::$count = (self::$count + 1) % PHP_INT_MAX;

        return self::$count;
    }

    public function createPropertyAccessor(): PropertyAccessorInterface
    {
        return new ForcePropertyAccessor(
            parent::createPropertyAccessor()
        );
    }
}
