<?php

declare(strict_types=1);

namespace RichCongress\FixtureTestBundle\Exception;

class MissingSeedException extends \LogicException
{
    public function __construct()
    {
        parent::__construct('Missing seed');
    }
}
