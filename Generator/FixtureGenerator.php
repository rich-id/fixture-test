<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Generator;

use Doctrine\Common\Persistence\Mapping\AbstractClassMetadataFactory;
use Faker\Factory;
use Faker\ORM\Doctrine\Populator;
use Nelmio\Alice\DataLoaderInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\ClassConfigurationGuesser;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory\ConfigurationGuesserRegistryFactory;
use RichCongress\FixtureTestBundle\Internal\CachedGetterTrait;
use RichCongress\FixtureTestBundle\Loader\CustomLoader;

/**
 * ClassGuesser FixtureGenerator
 *
 * @package    RichCongress\FixtureTestBundle\Generator
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @method DataLoaderInterface getDataLoader()
 */
final class FixtureGenerator
{
    use CachedGetterTrait;

    /** @var ConfigurationGuesserRegistryInterface */
    protected $configurationGuesserRegistry;

    public function __construct(ConfigurationGuesserRegistryInterface $configurationGuesserRegistry = null)
    {
        if ($configurationGuesserRegistry === null) {
            $factory = new ConfigurationGuesserRegistryFactory();
            $configurationGuesserRegistry = $factory->create();
        }

        $this->configurationGuesserRegistry = $configurationGuesserRegistry;
    }

    /**
     * @return object
     */
    public function generate(string $class, array $parameters = [])
    {
        $reflectionClass = new \ReflectionClass($class);
        $guesser = $this->configurationGuesserRegistry->getClassConfigurationGuesser($reflectionClass);
        $guessedConfig = $guesser->guess($reflectionClass);
        $configuration = array_merge($guessedConfig, $parameters);

        $objectSet = $this->getDataLoader()->loadData(
            [
                $class => [
                    'object' => $configuration,
                ]
            ]
        );

        return $objectSet->getObjects()['object'];
    }

    public function createDataLoader(): DataLoaderInterface
    {
        return new CustomLoader();
    }
}
