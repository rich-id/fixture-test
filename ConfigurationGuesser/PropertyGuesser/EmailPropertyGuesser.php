<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

/**
 * Class EmailPropertyGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class EmailPropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    protected static $priority = -50;

    public function guess(\ReflectionProperty $reflectionProperty): string
    {
        return '<email()>';
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
    {
        return $reflectionProperty->getName() === 'email';
    }
}
