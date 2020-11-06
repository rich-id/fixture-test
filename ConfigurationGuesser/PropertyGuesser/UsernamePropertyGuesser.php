<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

/**
 * Class UsernamePropertyGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class UsernamePropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    protected static $priority = -50;

    public function guess(\ReflectionProperty $reflectionProperty): string
    {
        return '<username()>';
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
    {
        return $reflectionProperty->getName() === 'username';
    }
}
