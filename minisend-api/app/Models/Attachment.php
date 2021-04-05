<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'mime_type',
        'extension'
    ];

    /**
     * Get the email that owns the Attachment
     */
    public function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function getPathAttribute($value)
    {
        return Storage::path($value);
    }
}
