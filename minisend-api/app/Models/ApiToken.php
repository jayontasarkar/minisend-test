<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'access_token'
    ];

    /**
     * Get the user that owns the ApiToken
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
