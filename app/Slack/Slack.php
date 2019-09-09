<?php

namespace App\Slack;

use App\Deploy;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class Slack
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function report(Deploy $deploy, Collection $tickets) : void
    {
        // Use the override channel if set
        $channel = config('slack.override_channel', $deploy->application->slack_channel);

        $this->client->post('https://slack.com/api/chat.postMessage', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('slack.token'),
            ],
            'body' => json_encode([
                'channel' => $channel,
                'text' => $this->constructMessage($deploy, $tickets),
            ]),
        ]);
    }

    private function constructMessage(Deploy $deploy, Collection $tickets) : string
    {
        return view('slack.deployment_message', [
            'user' => UserMapping::map($deploy->username),
            'stage' => ucfirst($deploy->stage),
            'tickets' => $tickets,
        ])->render();
    }
}
