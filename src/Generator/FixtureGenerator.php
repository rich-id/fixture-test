<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Generator;

use Nelmio\Alice\DataLoaderInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Context;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;
use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory\ConfigurationGuesserRegistryFactory;
use RichCongress\FixtureTestBundle\Internal\CachedGetterTrait;
use RichCongress\FixtureTestBundle\Loader\CustomLoader;

/**
 * ClassGuesser FixtureGenerator.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @method DataLoaderInterface getDataLoader()
 */
final class FixtureGenerator implements GeneratorInterface
{
    use CachedGetterTrait;

    /** @var ConfigurationGuesserRegistryInterface */
    protected $configurationGuesserRegistry;

    /** @var Context */
    protected $context;

    public function __construct(ConfigurationGuesserRegistryInterface $configurationGuesserRegistry = null)
    {
        if ($configurationGuesserRegistry === null) {
            $factory = new ConfigurationGuesserRegistryFactory();
            $configurationGuesserRegistry = $factory->create();
        }

        $this->configurationGuesserRegistry = $configurationGuesserRegistry;
        $this->context = new Context();
    }

    /** @return object */
    public function generate(string $class, array $parameters = [])
    {
        $reflectionClass = new \ReflectionClass($class);
        $guesser = $this->configurationGuesserRegistry->getClassConfigurationGuesser($reflectionClass, $this->context);
        $guessedConfig = $guesser->guess($reflectionClass, $this->context);
        $configuration = \array_merge($guessedConfig, $parameters);

        $objectSet = $this->getDataLoader()->loadData(
            [
                $class => [
                    'object' => $configuration,
                ],
            ]
        );

        return $objectSet->getObjects()['object'];
    }

    public function setLocale(string $language): self
    {
        $this->context->set(Context::LOCALE, $language);

        return $this;
    }

    public function createDataLoader(): DataLoaderInterface
    {
        return new CustomLoader();
    }
}
