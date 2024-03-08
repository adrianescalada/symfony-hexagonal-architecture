<?php

declare(strict_types=1);

namespace App\Context\Users\Domain;

use App\Context\Users\Domain\ValueObjects\UserId;
use DomainException;

final class UserNotExist extends DomainException
{
    public function __construct(private readonly UserId $id)
    {
        parent::__construct(sprintf('The user "%s" does not exist', $this->id->value()));
    }
}
