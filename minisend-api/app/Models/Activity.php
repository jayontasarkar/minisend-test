<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'email_id',
        'user_id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    /**
     * Get the email that owns the Activity
     */
    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    /**
     * Get the user that owns the Activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
