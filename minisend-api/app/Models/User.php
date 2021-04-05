<?php

namespace App\Models;

use App\Traits\Uuids;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get all of the attachments for the User
     */
    public function attachments()
    {
        return $this->hasManyThrough(Attachment::class, Email::class);
    }

    /**
     * Get all of the activities for the User
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get all of the emails for the User
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Get all of the tokens for the User
     */
    public function tokens()
    {
        return $this->hasMany(ApiToken::class);
    }
}
