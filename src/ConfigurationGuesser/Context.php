<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\ConfigurationGuesser;

/**
 * Class Context.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class Context
{
    public const LOCALE = 'language';

    /** @var array<string, mixed> */
    private $context;

    public function __construct(array $context = [])
    {
        $this->context = $context;
    }

    public function set(string $key, $value): self
    {
        $this->context[$key] = $value;

        return $this;
    }

    public function get(string $key)
    {
        return $this->context[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->context);
    }

    public function copy(): self
    {
        $new = new self();

        foreach ($this->context as $key => $value) {
            $new->set($key, $value);
        }

        return $new;
    }
}
