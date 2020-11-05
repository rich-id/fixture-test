<?php declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Tests\Resources\Object;

/**
 * ClassGuesser DummyUser
 *
 * @package    RichCongress\FixtureTestBundle\Tests\Resources\Object
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2020 RichCongress (https://www.richcongress.com)
 */
final class DummyUser
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $email;

    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var \DateTime */
    protected $dateAdd;

    /** @var \DateTime */
    protected $dateUpdate;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdd(): ?\DateTime
    {
        return $this->dateAdd;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdate(): ?\DateTime
    {
        return $this->dateUpdate;
    }
}
