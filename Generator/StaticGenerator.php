<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Generator;

use RichCongress\TestTools\Helper\ForceExecutionHelper;

/**
 * Class StaticGenerator
 *
 * @package    RichCongress\FixtureTestBundle\Generator
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
final class StaticGenerator implements GeneratorInterface
{
    /**
     * @return object
     */
    public function generate(string $class, array $parameters = [])
    {
        $object = new $class();

        foreach ($parameters as $property => $value) {
            ForceExecutionHelper::setValue($object, $property, $value);
        }

        return $object;
    }
}
