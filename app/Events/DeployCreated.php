<?php

namespace App\Events;

use App\Deploy;
use Illuminate\Queue\SerializesModels;

class DeployCreated
{
    use SerializesModels;

    public $deploy;

    public function __construct(Deploy $deploy)
    {
        $this->deploy = $deploy;
    }
}
