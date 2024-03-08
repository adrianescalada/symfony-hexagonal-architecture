<?php

declare(strict_types=1);

namespace App\Context\Users\Application\DTO;

use Symfony\Component\HttpFoundation\Request;

interface RequestDTO
{
    public function __construct(Request $request);
}
