<?php
namespace App\Parser\Portfolio\Stubs;

use App\Traits\EasyMake;

class PortfolioLinkStub
{
    use EasyMake;

    public string $name;

    public ?string $icon;

    public ?string $description;

    public string $url;
}
