<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Context\Users\Application\UserRemover;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class UserDeleteController extends AbstractController
{
    #[Route('/users/{id}', methods: ['DELETE'], requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(string $id, UserRemover $userRemover): Response
    {
        $userRemover->__invoke($id);

        return new Response('', Response::HTTP_OK);
    }
}
