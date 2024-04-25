<?php
namespace App\Parser\Portfolio;

use App\Parser\Portfolio\Stubs\PortfolioBioStub;
use App\Parser\Portfolio\Stubs\PortfolioChainStub;
use App\Parser\Portfolio\Stubs\PortfolioCollectionStub;
use App\Parser\Portfolio\Stubs\PortfolioLinkStub;
use App\Traits\EasyMake;
use ArrayHelpers\Arr;

class PortfolioParser
{
    use EasyMake;

    public PortfolioBioStub $bioStub;

    /**
     * @var array|PortfolioChainStub[]
     */
    public array $chains;

    public function parse(array $data): PortfolioParser
    {
        $this->bioStub = $this->resolveBio($data);
        $this->chains = $this->resolveChains($data);

        return $this;
    }

    private function resolveBio(array $data): PortfolioBioStub
    {
        $bioStub = PortfolioBioStub::make();
        $bioStub->bio = Arr::get($data, 'bio');

        foreach (Arr::get($data, 'socials') as $social) {
            $bioStub->socials[] = $this->resolveUrl($social);
        }

        return $bioStub;
    }

    private function resolveChains(array $data): array
    {
        $chains = [];

        foreach (Arr::get($data, 'chains') as $chain => $collections) {
            $chainStub = PortfolioChainStub::make();
            $chainStub->name = $chain;

            foreach ($collections as $collection) {
                $collectionStub = PortfolioCollectionStub::make();
                $collectionStub->name = Arr::get($collection, 'name');
                $collectionStub->sub = Arr::get($collection, 'sub');
                $collectionStub->description = Arr::get($collection, 'description');
                $collectionStub->image = Arr::get($collection, 'image');

                foreach (Arr::get($collection, 'markets') as $market) {
                    $collectionStub->markets[] = $this->resolveUrl($market);
                }

                $chainStub->collections[] = $collectionStub;
            }

            $chains[] = $chainStub;
        }

        return $chains;
    }

    private function resolveUrl($data): PortfolioLinkStub
    {
        $url = PortfolioLinkStub::make();
        $url->name = Arr::get($data, 'name');
        $url->icon = Arr::get($data, 'icon');
        $url->description = Arr::get($data, 'description');
        $url->url = Arr::get($data, 'url');

        return $url;
    }
}

