<?php

namespace App\Http\Controllers\Api;

use App\Models\ApiToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\TokenResource;

class TokenController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        return response()->json([
            'tokens' => TokenResource::collection(ApiToken::all())
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $token = $this->user->tokens()->create([
            'name' => $request->name,
            'access_token' => Str::random(50)
        ]);

        return response()->json(['token' => new TokenResource($token)]);
    }

    public function destroy($token)
    {
        $token = ApiToken::findOrFail($token);
        if (! Gate::allows('delete-api-token', $token)) {
            abort(403, "Not authorized to delete token");
        }
        
        \Cache::forget($token);
        $token->delete();

        return $token;
    }
}
