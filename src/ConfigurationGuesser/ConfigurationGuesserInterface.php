<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser;

use RichCongress\FixtureTestBundle\ConfigurationGuesser\Registry\ConfigurationGuesserRegistryInterface;

/**
 * Class ConfigurationGuesserInterface.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
interface ConfigurationGuesserInterface
{
    public function getPriority(): int;

    public function setConfigurationGuesserRegistry(ConfigurationGuesserRegistryInterface $registry): void;
}
