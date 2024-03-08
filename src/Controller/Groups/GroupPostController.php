<?php

declare(strict_types=1);

namespace App\Controller\Groups;

use App\Context\Groups\Application\GroupCreator;
use App\Context\Groups\Domain\ValueObjects\GroupId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GroupPostController extends AbstractController
{
    #[Route('/groups', methods: ['POST'])]
    public function __invoke(Request $request, GroupCreator $groupCreator): Response
    {
        $id = GroupId::random()->value();
        $name = $request->get('name');
        $groupCreator->__invoke($id, $name);

        return new Response('', Response::HTTP_CREATED);
    }
}
