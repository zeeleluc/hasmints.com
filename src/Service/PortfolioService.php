<?php
namespace App\Service;

use App\Parser\PortfolioParser;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PortfolioService
{
    private ParameterBagInterface $parameterBag;

    private UrlGeneratorInterface $router;

    public function __construct(ParameterBagInterface $parameterBag, UrlGeneratorInterface $router)
    {
        $this->parameterBag = $parameterBag;
        $this->router = $router;
    }

    public function get(string $portfolioName): PortfolioParser
    {
        $data = $this->parameterBag->get('portfolio_' . $portfolioName);

        return PortfolioParser::make()->parse($data);
    }

    public function names(): array
    {
        $names = $this->parameterBag->get('portfolios');
        asort($names);

        return $names;
    }

    public function urls(string $skip = null): array
    {
        $urls = [];
        foreach ($this->names() as $portfolioName) {
            if ($skip && $skip === $portfolioName) {
                continue;
            }
            $urls[$portfolioName] = $this->router->generate('portfolio', [
                'subdomain' => $portfolioName,
                'domain' => $this->parameterBag->get('ext')
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }

        return $urls;
    }
}
