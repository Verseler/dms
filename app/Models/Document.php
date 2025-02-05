<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'user_id'
    ];

    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory;

    public function user()
    {
        //
        return $this->belongsTo(User::class);
    }
}
