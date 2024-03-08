<?php

declare(strict_types=1);

namespace App\Context\Users\Application\DTO;

use Symfony\Component\HttpFoundation\Request;

final class GetUsersRequest implements RequestDTO
{
    public readonly int $page;
    public readonly int $limit;
    public readonly ?string $id;
    public readonly string $sort;
    public readonly string $order;
    public readonly ?string $name;

    public function __construct(Request $request)
    {
        $this->page = $request->query->getInt('page');
        $this->limit = $request->query->getInt('limit');
        $this->id = $request->query->get('id');
        $this->sort = $request->query->get('sort');
        $this->order = $request->query->get('order');
        $this->name = $request->query->get('name');
    }
}
