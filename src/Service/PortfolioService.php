<?php
namespace App\Service;

use App\Parser\PortfolioParser;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PortfolioService
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function get(string $portfolioName): PortfolioParser
    {
        $data = $this->parameterBag->get('portfolio_' . $portfolioName);

        return PortfolioParser::make()->parse($data);
    }
}
