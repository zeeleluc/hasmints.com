<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/')]
final class HomeController extends AbstractController
{

    public function index(): Response
    {
        $portfolioUrls = [];
        $portfolioNames = $this->getParameter('portfolios');
        sort($portfolioNames);
        foreach ($portfolioNames as $portfolioName) {
            $portfolioUrls[$portfolioName] = $this->generateUrl('portfolio', [
                'subdomain' => $portfolioName,
                'domain' => $this->getParameter('ext')
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return $this->render('default/homepage.html.twig', [
            'portfolioUrls' => $portfolioUrls,
        ]);
    }
}
