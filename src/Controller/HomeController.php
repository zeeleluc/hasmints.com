<?php

namespace App\Controller;

use App\Service\GitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{

    public function index(
        GitService $gitService
    ): Response {
        return $this->render('default/homepage.html.twig', [
            'repositories' => $gitService->repositories(),
        ]);
    }
}
