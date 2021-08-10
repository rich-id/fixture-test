<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Generator;

/**
 * Interface GeneratorInterface.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
interface GeneratorInterface
{
    /** @return object */
    public function generate(string $class, array $parameters = []);
}
