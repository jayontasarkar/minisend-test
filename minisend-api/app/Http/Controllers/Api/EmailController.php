<?php

namespace App\Http\Controllers\Api;

use App\Models\Email;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EmailStoreRequest;
use App\Jobs\StoreEmailAndDependenciesJob;

class EmailController extends Controller
{
    public function show(Email $email)
    {
        $email->load(['activities', 'attachments']);
        return response()->json([
            'email' => $email
        ]);
    }

    public function store(EmailStoreRequest $request)
    {
        $payload = $request->only(['recipient', 'sender', 'subject', 'html_content', 'text_content', 'userId']);
        if ($request->hasFile('attachments')) {
            $paths = [];
            foreach ($request->file('attachments') as $file) {
                if ($file !== null) {
                    $ext = $file->getClientOriginalExtension();
                    $name = time() . Str::random(10) . ".{$ext}";
                    $path = Storage::putFileAs('uploads/emails', $file, $name);
                    array_push($paths, ['path' => $path]);
                }
            }
            if (count($paths) > 0) {
                $payload['paths'] = $paths;
            }
        }

        StoreEmailAndDependenciesJob::dispatch($payload);
    }
}
