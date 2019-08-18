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
            'app' => ['required', 'string', 'exists:applications,name'],
            'stage' => ['required', 'string', Rule::in(Stage::ALL)],
            'sha1' => ['required', 'string', 'size:40'],
        ]);

        Deploy::create([
            'application_id' => Application::name($data['app'])->id,
            'stage' => $data['stage'],
            'sha1' => $data['sha1'],
        ]);

        return response(null, 204);
    }
}
