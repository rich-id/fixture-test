<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;

/**
 * Class FakerFormatterNamePropertyGuesser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class FakerFormatterNamePropertyGuesser extends AbstractPropertyConfigurationGuesser
{
    /** @var array<string, string|string[]> */
    protected static $fakerFormatterMapping = [
        'firstName'   => 'firstname',
        'lastName'    => 'lastname',
        'phoneNumber' => ['phonenumber', 'phone'],
        'email'       => 'email',
        'username'    => ['username', 'usernameCanonical'],
        'password'    => 'password',
        'url'         => 'url',
    ];

    /** @var int */
    protected static $priority = -100;

    public function guess(\ReflectionProperty $reflectionProperty, Context $context): string
    {
        $formatter = $this->findFakerFormatter($reflectionProperty);

        if ($formatter === null) {
            throw new \LogicException('No formatter found');
        }

        return $this->useFakerFormatter($context, $formatter);
    }

    public function supports(\ReflectionProperty $reflectionProperty, Context $context): bool
    {
        return $this->findFakerFormatter($reflectionProperty) !== null;
    }

    protected function findFakerFormatter(\ReflectionProperty $reflectionProperty): ?string
    {
        $name = $reflectionProperty->getName();

        foreach (self::$fakerFormatterMapping as $formatter => $properties) {
            $isSupported = \in_array(
                \strtolower($name),
                (array) $properties,
                true
            );

            if ($isSupported) {
                return $formatter;
            }
        }

        return null;
    }
}
