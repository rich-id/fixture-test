<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use PhpDocReader\PhpDocReader;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\Internal\CachedGetterTrait;

/**
 * Class DateTimePropertyGuesser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @method PhpDocReader getPhpDocReader()
 */
class DateTimePropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    use CachedGetterTrait;

    /** @var int */
    protected static $priority = -50;

    /** @var string */
    protected static $lowerBound = '"-200 days"';

    /** @var string */
    protected static $higherBound = '"now"';

    public function guess(\ReflectionProperty $reflectionProperty, Context $context): string
    {
        return $this->useFakerFormatter(
            $context,
            'dateTimeBetween',
            static::$lowerBound,
            static::$higherBound
        );
    }

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool
    {
        $phpDocReader = $this->getPhpDocReader();
        $type = $phpDocReader->getPropertyType($reflectionProperty);

        return $type === \DateTime::class;
    }

    private function createPhpDocReader(): PhpDocReader
    {
        return new PhpDocReader();
    }
}
