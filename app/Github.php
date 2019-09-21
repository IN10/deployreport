<?php

namespace App;

use Github\Client;
use Github\ResultPager;
use Illuminate\Support\Collection;

class Github
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $this->client->authenticate(
            config('github.token'),
            null,
            \Github\Client::AUTH_HTTP_TOKEN
        );
    }

    /**
     * Retrieve a collection of commit messages between commit 1 (inclusive) and
     * commit 2 (exclusive). Use the last commit as the first argument.
     */
    public function messagesBetween(string $repository, string $hash1, string $hash2) : Collection
    {
        $owner = explode('/', $repository)[0];
        $repository = explode('/', $repository)[1];

        $data = $this->client->api('repo')->commits()->compare($owner, $repository, $hash2, $hash1);

        return collect($data['commits'])->pluck('commit.message');
    }

    /**
     * A list of all repositories
     */
    public function repositories() : Collection
    {
        $organisation = config('github.organisation');

        $organizationApi = $this->client->api('organization');
        $paginator = new ResultPager($this->client);
        $parameters = [$organisation, ['sort' => 'full_name']];
        $data = $paginator->fetchAll($organizationApi, 'repositories', $parameters);

        return collect($data)->pluck('full_name');
    }
}
