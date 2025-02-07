<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentShare extends Model
{

    protected $table = 'document_shares';

    protected $primaryKey = 'document_id';

    protected $fillable = [
        'document_id',
        'recipient_id',
    ];

    /** @use HasFactory<\Database\Factories\DocumentShareFactory> */
    use HasFactory;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
