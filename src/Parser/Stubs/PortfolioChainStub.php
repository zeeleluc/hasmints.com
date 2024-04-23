<?php
namespace App\Parser\Stubs;

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
