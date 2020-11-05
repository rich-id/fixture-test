<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

/**
 * Class DateUpdatePropertyGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class DateUpdatePropertyGuesser extends DateTimePropertyGuesser
{
    public function guess(\ReflectionProperty $reflectionProperty): string
    {
        return sprintf('<dateTimeBetween(%s, %s)', '$dateAdd', static::$higherBound);
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
    {
        return parent::supports($reflectionProperty) && $reflectionProperty->getName() === 'dateUpdate';
    }
}
