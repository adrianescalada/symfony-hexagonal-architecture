<?php

declare(strict_types=1);

namespace App\Controller\Groups;

use App\Context\Groups\Application\GroupRemover;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class GroupDeleteController extends AbstractController
{
    #[Route('/groups/{id}', methods: ['DELETE'], requirements: ['id' => Requirement::UUID_V4])]
    public function __invoke(string $id, GroupRemover $groupRemover): Response
    {
        $groupRemover->__invoke($id);

        return new Response('', Response::HTTP_OK);
    }
}
