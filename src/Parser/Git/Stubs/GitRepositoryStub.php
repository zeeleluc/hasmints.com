<?php
namespace App\Parser\Git\Stubs;

use App\Traits\EasyMake;
use Carbon\Carbon;

class GitRepositoryStub
{
    use EasyMake;

    public string $name;

    public ?string $description;

    public string $url;

    public int $totalCommits;

    public Carbon $lastCommitDone;

    public string $lastCommitMessage;

    public string $lastCommitUrl;

    public string $lastCommitSha;

}