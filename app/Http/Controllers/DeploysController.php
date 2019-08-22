<?php

namespace App\Http\Controllers;

use App\Application;
use App\Deploy;
use App\Stage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class DeploysController extends Controller
{
    public function create(Request $request) : Response
    {
        $data = $request->validate([
            'app' => ['required', 'string'],
            'stage' => ['required', 'string', Rule::in(Stage::ALL)],
            'sha1' => ['required', 'string', 'size:40'],
        ]);

        $application = Application::firstOrCreate(['name' => $data['app']]);

        Deploy::create([
            'application_id' => $application->id,
            'stage' => $data['stage'],
            'sha1' => $data['sha1'],
        ]);

        return response(null, 204);
    }
}
