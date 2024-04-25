<?php
namespace App\Parser\Portfolio\Stubs;

use App\Traits\EasyMake;

class PortfolioCollectionStub
{
    use EasyMake;

    public string $name;

    public ?string $sub;

    public ?string $description;

    public string $image;

    /**
     * @var array|PortfolioLinkStub[]
     */
    public array $markets = [];
}
