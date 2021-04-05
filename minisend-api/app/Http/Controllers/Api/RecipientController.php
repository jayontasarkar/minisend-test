<?php

namespace App\Http\Controllers\Api;

use App\Models\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecipientController extends Controller
{
    public function __invoke($email)
    {
        $emails = Email::where('recipient', $email)->get();

        return response()->json([
            'recipient' => $email,
            'emails'    => $emails
        ]);
    }
}
