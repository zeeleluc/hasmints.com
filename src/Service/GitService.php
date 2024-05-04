<?php
namespace App\Service;

use App\Parser\Git\Stubs\GitRepositoryStub;
use Carbon\Carbon;
use Github\Client;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GitService
{
    private ParameterBagInterface $parameterBag;

    private Client $client;

    private array $config;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
        $this->client = new Client();
        $this->config = $this->parameterBag->get('git');
    }

    /**
     * @return array|GitRepositoryStub[]
     * @throws InvalidArgumentException
     */
    public function repositories(): array
    {
        $cache = new FilesystemAdapter();

        return $cache->get('repositories', function (ItemInterface $item): array {
            $item->expiresAfter(3600 / 4);

            $gitRepositories = $this->filterGitRepositories($this->getGitRepositories());
            $repositories = [];

            foreach ($gitRepositories as $repository) {
                $repositoryStub = GitRepositoryStub::make();
                $repositoryStub->name = $repository['name'];
                $repositoryStub->url = $repository['html_url'];
                $repositoryStub->description = $repository['description'];

                $commits = $this->getCommitsForRepository($repository['name']);
                $lastCommit = $commits[0];

                $repositoryStub->totalCommits = count($commits); // @todo
                $repositoryStub->lastCommitDone = Carbon::parse($lastCommit['commit']['committer']['date']);
                $repositoryStub->lastCommitMessage = $lastCommit['commit']['message'];
                $repositoryStub->lastCommitUrl = $lastCommit['html_url'];
                $repositoryStub->lastCommitSha = $lastCommit['sha'];

                $repositories[] = $repositoryStub;
            }

            usort($repositories, function($a, $b) {
                return $a->lastCommitDone < $b->lastCommitDone;
            });

            return $repositories;
        });
    }

    private function getCommitsForRepository(string $repositoryName): array
    {
        return $this->client
            ->api('repo')
            ->commits()
            ->all(
                $this->config['owner'],
                $repositoryName,
                ['branch' => 'main']
            );
    }

    private function getGitRepositories(): array
    {
        return $this->client->api('user')->repositories($this->config['owner']);
    }

    private function filterGitRepositories(array $gitRepositories): array
    {
        $repositories = $this->getGitRepositories();

        foreach ($repositories as $key => $repository) {
            if (!in_array($repository['name'], $this->config['repositories'])) {
                // filter them so we just need to make 1 API call
                unset($repositories[$key]);
            }
        }

        return $repositories;
    }
}
