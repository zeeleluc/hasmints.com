<?php

namespace App\Controller;

use App\Service\PortfolioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PortfolioController extends AbstractController
{
    #[Route('/portfolio', name: 'app_portfolio')]
    public function index(
        PortfolioService $portfolioService,
        Request $request
    ): Response
    {
        $subdomain = $request->attributes->get('subdomain');

        return $this->render('portfolio/index.html.twig', [
            'portfolio_name' => $subdomain,
            'portfolio' => $portfolioService->get($subdomain),
            'portfolio_urls' => $portfolioService->urls($subdomain),
        ]);
    }
}
