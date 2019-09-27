<?php

namespace App\Listeners;

use App\Events\DeployCreated;
use App\Github;
use App\JIRA;
use App\Slack\Slack;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessDeployment
{
    private $github;
    private $slack;
    private $jira;

    public function __construct(Github $github, Slack $slack, JIRA $jira)
    {
        $this->github = $github;
        $this->slack = $slack;
        $this->jira = $jira;
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

        Log::info("Reporting on deployment {$deploy->id}");

        $messages = $this->github->messagesBetween($application->github_repository, $deploy->sha1, $previous->sha1);
        $tickets = $this->jira->parseTickets($messages, $application->jira_projectcode);

        $this->slack->report($deploy, $tickets);
    }
}
