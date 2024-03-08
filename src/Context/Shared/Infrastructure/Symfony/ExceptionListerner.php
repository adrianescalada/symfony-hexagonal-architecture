<?php

declare(strict_types=1);

namespace App\Context\Shared\Infrastructure\Symfony;

use App\Context\Groups\Domain\GroupNotExist;
use App\Context\Groups\Domain\GroupWithUsers;
use App\Context\Users\Domain\UserNotExist;
use App\Context\Users\Domain\UserFilterNotValidate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new Response();
        $response->setContent($exception->getMessage());

        $statusCode = match (get_class($exception)) {
            UserNotExist::class => Response::HTTP_NOT_FOUND,
            GroupNotExist::class => Response::HTTP_NOT_FOUND,
            GroupWithUsers::class => Response::HTTP_NOT_FOUND,
            UserFilterNotValidate::class => Response::HTTP_NOT_FOUND,
            default => Response::HTTP_INTERNAL_SERVER_ERROR
        };


        $response->setStatusCode($statusCode);

        $event->setResponse($response);
    }
}
