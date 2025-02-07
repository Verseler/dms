<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'user_id'
    ];

    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory;

    public function documentShare()
    {
        return $this->hasMany(DocumentShare::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'document_shares', 'document_id', 'recipient_id')
            ->withTimestamps();
    }
}
