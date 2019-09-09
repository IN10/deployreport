<?php

namespace App\Listeners;

use App\Events\DeployCreated;
use App\Github;
use App\Slack\Slack;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessDeployment
{
    private $github;
    private $slack;

    public function __construct(Github $github, Slack $slack)
    {
        $this->github = $github;
        $this->slack = $slack;
    }

    public function handle(DeployCreated $event)
    {
        $deploy = $event->deploy;
        $application = $deploy->application;

        if (!$application->canReport()) {
            Log::info("Cannot report on deploy {$deploy->id} for {$application->name}");
            return;
        }

        // We need a previous deployment to compare what has changed
        $previous = $deploy->previous();
        if (!$previous) {
            Log::info("Deployment {$deploy->id} has no previous deployment");
            return;
        }

        $messages = $github->messagesBetween($application->github_repository, $deploy->sha1, $previous->sha1);

        $this->slack->report($deploy);

        // foreach message
            // if it contains a ticket number
            // write a message on that ticket
    }
}
