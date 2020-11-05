<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class IdPropertyGuesser
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class IdPropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    protected static $priority = 100;

    public function guess(\ReflectionProperty $reflectionProperty): ?int
    {
        return null;
    }

    public function supports(\ReflectionProperty $reflectionProperty): bool
    {
        return $reflectionProperty->getName() === 'id';
    }
}
