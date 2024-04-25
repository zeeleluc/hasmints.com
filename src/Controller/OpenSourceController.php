<?php

namespace App\Controller;

use App\Service\GitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OpenSourceController extends AbstractController
{
    #[Route('/opensource', name: 'app_opensource')]
    public function index(GitService $gitService): Response
    {
       return $this->render('opensource/index.html.twig', [
           'repositories' => $gitService->repositories(),
       ]);
    }
}
