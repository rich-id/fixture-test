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

    public function __construct(?FakerGenerator $fakerGenerator = null)
    {
        parent::__construct($fakerGenerator);
    }

    public function getSeed(): int
    {
        $seed = (int) \getenv('PHPUNIT_SEED');

        if ($seed === 0) {
            throw new MissingSeedException();
        }

        return $seed;
    }

    public function createPropertyAccessor(): PropertyAccessorInterface
    {
        return new ForcePropertyAccessor(
            parent::createPropertyAccessor()
        );
    }
}
