<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'subject',
        'text_content',
        'html_content',
        'status',
        'user_id',
        'recipient',
        'sender'
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
     * Get the user that owns the Email
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the attachments for the Email
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
