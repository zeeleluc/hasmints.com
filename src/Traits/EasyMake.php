<?php
namespace App\Traits;

trait EasyMake
{

    public static function make(): self
    {
        return new self();
    }
}
