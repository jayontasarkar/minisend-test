<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiyResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function __invoke(Request $request)
    {
        $activities = (new Activity())->newQuery();
        if ($request->has('q')) {
            $q = $request->q;
            $activities->whereHas('email', function($query) use ($q) {
                $query->where('recipient', 'LIKE', "%{$q}%")
                    ->orWhere('sender', 'LIKE', "%{$q}%")
                    ->orWhere('subject', 'LIKE', "%{$q}%");
            });
        }
        if ($request->has('tags') && count($request->tags) > 0) {
            $activities->whereIn('status', $request->tags);
        }
        $result = $activities->with('email')->latest()->get();
        
        return ActivitiyResource::collection($result);
    }
}
