<?php

declare(strict_types=1);

namespace App\Controller\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Context\Users\Application\SearchUsers;
use App\Context\Users\Application\Filter\UserFilter;

final class SearchUserController extends AbstractController
{
    #[Route('users', methods: ['GET'])]
    public function __invoke(Request $request, SearchUsers $useCase): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $sort = $request->query->get('sort');
        $order = $request->query->get('order');
        $name = $request->query->get('name');

        $filter = new UserFilter($page, $limit, $sort, $order, $name);

        $output = $useCase->execute($filter);

        return $this->json($output);
    }
}
