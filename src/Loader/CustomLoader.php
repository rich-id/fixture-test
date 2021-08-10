<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Loader;

use Nelmio\Alice\Loader\NativeLoader;
use RichCongress\FixtureTestBundle\Internal\ForcePropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * ClassGuesser CustomLoader.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class CustomLoader extends NativeLoader
{
    public function createPropertyAccessor(): PropertyAccessorInterface
    {
        return new ForcePropertyAccessor(
            parent::createPropertyAccessor()
        );
    }
}
