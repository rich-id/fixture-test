<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Internal;

use Symfony\Component\PropertyAccess\Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * ClassGuesser ForcePropertyAccessor.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * Available and tested here: https://github.com/richcongress/test-tools/blob/master/Accessor/ForcePropertyAccessor.php
 *
 * @internal
 * @codeCoverageIgnore
 */
final class ForcePropertyAccessor implements PropertyAccessorInterface
{
    /** @var PropertyAccessorInterface|null */
    private $innerPropertyAccessor;

    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->innerPropertyAccessor = $propertyAccessor;

        if ($this->innerPropertyAccessor === null) {
            $this->innerPropertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
                ->enableMagicCall()
                ->getPropertyAccessor();
        }
    }

    public function setValue(&$objectOrArray, $propertyPath, $value): void
    {
        try {
            $this->innerPropertyAccessor->setValue($objectOrArray, $propertyPath, $value);
        } catch (Exception\NoSuchPropertyException $exception) {
            $propertyReflection = $this->getPropertyReflection($objectOrArray, $propertyPath);

            if ($propertyReflection === null) {
                throw $exception;
            }

            $propertyReflection->setAccessible(true);
            $propertyReflection->setValue($objectOrArray, $value);
            $propertyReflection->setAccessible(false);
        }
    }

    public function getValue($objectOrArray, $propertyPath): mixed
    {
        try {
            return $this->innerPropertyAccessor->getValue($objectOrArray, $propertyPath);
        } catch (Exception\NoSuchPropertyException $exception) {
            $propertyReflection = $this->getPropertyReflection($objectOrArray, $propertyPath);

            if ($propertyReflection === null) {
                throw $exception;
            }

            $propertyReflection->setAccessible(true);
            $value = $propertyReflection->getValue($objectOrArray);
            $propertyReflection->setAccessible(false);

            return $value;
        }
    }

    public function isWritable($objectOrArray, $propertyPath): bool
    {
        return $this->innerPropertyAccessor->isWritable($objectOrArray, $propertyPath)
            || $this->getPropertyReflection($objectOrArray, $propertyPath) !== null;
    }

    public function isReadable($objectOrArray, $propertyPath): bool
    {
        return $this->innerPropertyAccessor->isReadable($objectOrArray, $propertyPath)
            || $this->getPropertyReflection($objectOrArray, $propertyPath) !== null;
    }

    private function getPropertyReflection($objectOrArray, string $propertyPath): ?\ReflectionProperty
    {
        if (!\is_object($objectOrArray)) {
            return null;
        }

        $reflectionClass = new \ReflectionClass($objectOrArray);

        while ($reflectionClass instanceof \ReflectionClass) {
            if ($reflectionClass->hasProperty($propertyPath)) {
                return $reflectionClass->getProperty($propertyPath);
            }

            $reflectionClass = $reflectionClass->getParentClass();
        }

        return null;
    }
}
