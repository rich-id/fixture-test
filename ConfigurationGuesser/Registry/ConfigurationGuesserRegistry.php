<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassGuesser\ClassConfigurationGuesserInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\PropertyGuesser\PropertyConfigurationGuesserInterface;

/**
 * Class ConfigurationGuesserRegistry
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class ConfigurationGuesserRegistry implements ConfigurationGuesserRegistryInterface
{
    /** @var ClassConfigurationGuesserInterface[] */
    protected $classConfigurationGuessers = [];

    /** @var PropertyConfigurationGuesserInterface[] */
    protected $propertyConfigurationGuessers = [];

    /** @var bool */
    private $classGuessersSorted = false;

    /** @var bool  */
    private $propertyGuessersSorted = false;

    public function addClassConfigurationGuesser(ClassConfigurationGuesserInterface $guesser): void
    {
        $this->classConfigurationGuessers[] = $guesser;
        $this->classGuessersSorted = false;
    }

    public function addPropertyConfigurationGuesser(PropertyConfigurationGuesserInterface $guesser): void
    {
        $this->propertyConfigurationGuessers[] = $guesser;
        $this->propertyGuessersSorted = false;
    }

    public function getClassConfigurationGuesser(\ReflectionClass $class): ClassConfigurationGuesserInterface
    {
        $this->sortClassConfigurationGuessers();

        foreach ($this->classConfigurationGuessers as $guesser) {
            if ($guesser->supports($class)) {
                return $guesser;
            }
        }

        throw new \LogicException('No class configuration guesser found for the class ' . $class->getName());
    }

    public function getPropertyConfigurationGuesser(\ReflectionProperty $property): PropertyConfigurationGuesserInterface
    {
        $this->sortPropertyConfigurationGuessers();

        foreach ($this->propertyConfigurationGuessers as $guesser) {
            if ($guesser->supports($property)) {
                return $guesser;
            }
        }

        throw new \LogicException('No property configuration guesser found for the property ' . $property->getName());
    }

    private function sortClassConfigurationGuessers(): void
    {
        if ($this->classGuessersSorted) {
            return;
        }

        usort(
            $this->classConfigurationGuessers,
            static function (ClassConfigurationGuesserInterface $guesser1, ClassConfigurationGuesserInterface $guesser2) {
                $priority1 = $guesser1->getPriority();
                $priority2 = $guesser2->getPriority();

                if ($priority1 === $priority2) {
                    return 0;
                }

                return ($priority1 < $priority2) ? -1 : 1;
            }
        );

        $this->classGuessersSorted = true;
    }

    private function sortPropertyConfigurationGuessers(): void
    {
        if ($this->propertyGuessersSorted) {
            return;
        }

        usort(
            $this->propertyConfigurationGuessers,
            static function (PropertyConfigurationGuesserInterface $guesser1, PropertyConfigurationGuesserInterface $guesser2) {
                $priority1 = $guesser1->getPriority();
                $priority2 = $guesser2->getPriority();

                if ($priority1 === $priority2) {
                    return 0;
                }

                return ($priority1 < $priority2) ? -1 : 1;
            }
        );

        $this->propertyGuessersSorted = true;
    }
}
