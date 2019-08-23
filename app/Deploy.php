<?php

namespace App;

use App\Events\DeployCreated;
use Illuminate\Database\Eloquent\Model;

class Deploy extends Model
{
    protected $fillable = ['application_id', 'stage', 'sha1', 'username'];

    protected $dispatchesEvents = [
        'created' => DeployCreated::class,
    ];

    /**
     * Find the previous deployment for this <app, stage>
     */
    public function previous() : ?self
    {
        return self::where('application_id', $this->application_id)
            ->where('stage', $this->stage)
            ->where('id', '!=' $this->id)
            ->where('created_at', '<', $this->created_at)
            ->orderBy('created_at', 'desc')->first();
    }
}
