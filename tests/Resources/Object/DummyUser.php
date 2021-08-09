<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\Resources\Object;

/**
 * ClassGuesser DummyUser.
 *
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class DummyUser
{
    /** @var int */
    private $id;

    /** @var string */
    private $email;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var \DateTime */
    private $dateAdd;

    /** @var \DateTime */
    private $dateUpdate;

    /** @var string */
    private $anyString;

    /** @var int */
    private $anyInt;

    /** @var float */
    private $anyFloat;

    /** @var array */
    private $anyArray;

    private $untypedProperty;

    /** @return int */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** @return string */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /** @return string */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /** @return string */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /** @return \DateTime */
    public function getDateAdd(): ?\DateTime
    {
        return $this->dateAdd;
    }

    /** @return \DateTime */
    public function getDateUpdate(): ?\DateTime
    {
        return $this->dateUpdate;
    }
}
