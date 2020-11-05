<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;

/**
 * Interface ConfigurationGuesserRegistryFactoryInterface
 *
 * @package    RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\Factory
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface ConfigurationGuesserRegistryFactoryInterface
{
    public function create(): ConfigurationGuesserRegistryInterface;
}
