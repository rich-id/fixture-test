<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use PhpDocReader\PhpDocReader;
use RichCongress\FixtureTestBundle\Internal\CachedGetterTrait;

/**
 * Class DateTimePropertyGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
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
    protected static $lowerBound = '"-100 years"';

    /** @var string */
    protected static $higherBound = '"now"';

    public function guess(\ReflectionProperty $reflectionProperty): string
    {
        return sprintf('<dateTimeBetween(%s, %s)', static::$lowerBound, static::$higherBound);
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
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
