<?php
namespace App\Parser\Portfolio\Stubs;

use App\Traits\EasyMake;

class PortfolioChainStub
{
    use EasyMake;

    public string $name;

    /**
     * @var array|PortfolioCollectionStub[]
     */
    public array $collections = [];
}
