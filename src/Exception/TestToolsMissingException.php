<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Exception;

/**
 * Class TestToolsMissingException.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
final class TestToolsMissingException extends \Exception
{
    public function __construct(string $class, string $method)
    {
        $message = \sprintf(
            'To use %s::%s, you need to install the library richcongress/test-tools.',
            $class,
            $method
        );

        parent::__construct($message);
    }
}
