<?php

namespace App\Listeners;

use App\Events\DeployCreated;
use App\Github\Github;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessDeployment
{
    private $github;

    public function __construct(Github $github)
    {
        $this->github = $github;
    }

    public function handle(DeployCreated $event)
    {
        $deploy = $event->deploy;
        $application = $deploy->application;

        // We need a previous deployment to compare what has changed
        $previous = $deploy->previous();
        if (!$previous) {
            Log::info("Deployment {$deploy->id} has no previous deployment");
            return;
        }

        if (!$application->canReport()) {
            Log::info("Cannot report on deploy {$deploy->id} for {$application->name}");
            return;
        }

        $messages = $github->messagesBetween($application->github_repository, $deploy->sha1, $previous->sha1);

        // report to slack on the deploy

        // foreach message
            // if it contains a ticket number
            // write a message on that ticket
    }
}
