<?php

declare(strict_types=1);

namespace App\Context\Users\Application\Filter;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Context\Users\Infrastructure\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\GenericException;
use App\Context\Users\Domain\UserFilterNotValidate;

final class UserFilter
{
    private const PAGE = 1;
    private const LIMIT = 10;
    private const ALLOWED_SORT_PARAMS = ['name', 'id'];
    private const ALLOWED_ORDER_PARAMS = ['asc', 'desc'];

    public readonly int $page;
    public readonly int $limit;

    public function __construct(
        int $page,
        int $limit,
        public readonly string $sort,
        public readonly string $order,
        public readonly ?string $name
    ) {
        if (0 !== $page) {
            $this->page = $page;
        } else {
            $this->page = self::PAGE;
        }

        if (0 !== $limit) {
            $this->limit = $limit;
        } else {
            $this->limit = self::LIMIT;
        }

        $this->validateSort($this->sort);
        $this->validateOrder($this->order);
        $this->validatePage($this->page);
        $this->validateLimit($this->limit);
    }

    private function validatePage(int $page): void
    {
        if ($page <= 0) {
            throw new UserFilterNotValidate('Invalid page value.', Response::HTTP_BAD_REQUEST);
        }
    }

    private function validateLimit(int $limit): void
    {
        if ($limit <= 0) {
            throw new UserFilterNotValidate('Invalid limit value.', Response::HTTP_BAD_REQUEST);
        }
    }

    private function validateSort(string $sort): void
    {
        if (!\in_array($sort, self::ALLOWED_SORT_PARAMS, true)) {
            throw new UserFilterNotValidate(\sprintf('Invalid sort param [%s]', $sort), Response::HTTP_NOT_FOUND);
        }
    }

    private function validateOrder(string $order): void
    {
        if (!\in_array($order, self::ALLOWED_ORDER_PARAMS, true)) {
            throw new UserFilterNotValidate(\sprintf('Invalid order param [%s]', $order),  Response::HTTP_BAD_REQUEST);
        }
    }
}
