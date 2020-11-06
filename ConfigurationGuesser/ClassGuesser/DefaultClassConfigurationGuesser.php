<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser;

/**
 * Class DefaultClassConfigurationGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class DefaultClassConfigurationGuesser extends AbstractClassConfigurationGuesser
{
    /** @var int */
    protected static $priority = -100;

    /** @var array<string, array<string, mixed>> */
    protected static $guessesCache = [];

    public function guess(\ReflectionClass $reflectionClass): array
    {
        $class = $reflectionClass->getName();

        if (!array_key_exists($class, static::$guessesCache)) {
            $config = [];

            foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                $name = $reflectionProperty->getName();

                try {
                    $guesser = $this->configurationGuesserRegistry->getPropertyConfigurationGuesser($reflectionProperty);
                    $value = $guesser->guess($reflectionProperty);

                    if ($value !== null) {
                        $config[$name] = $value;
                    }
                } catch (\LogicException $e) {
                    // Skipped
                }
            }

            static::$guessesCache[$class] = $config;
        }

        return static::$guessesCache[$class];
    }

    public function supports(\ReflectionClass $reflectionClass): bool
    {
        return true;
    }

//    protected function guessProperty(\ReflectionProperty $reflectionProperty): ?string
//    {
//        $name = $reflectionProperty->getName();
//        $datetimeConfig = '<dateTimeBetween(%s, "now")>';
//
//        switch ($name) {
//            case 'id':
//                return null;
//
//            case 'username':
//            case 'email':
//                return sprintf('<%s()>', $name);
//
//            case 'dateAdd':
//                return sprintf($datetimeConfig, '"-200 days"');
//
//            case 'dateUpdate':
//                return sprintf($datetimeConfig, '$dateAdd');
//
//            default:
//                // TODO: guess
//                return '';
//        }
//    }
}
