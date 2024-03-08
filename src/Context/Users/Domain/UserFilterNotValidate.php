<?php

declare(strict_types=1);

namespace App\Context\Users\Domain;

use Symfony\Component\HttpFoundation\Response;

use DomainException;

final class UserFilterNotValidate extends DomainException
{
    public function __construct(string $message, int $httpCode = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $httpCode);
    }
}
