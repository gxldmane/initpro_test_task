<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenderFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'file_name',
        'file_link'
    ];

    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }

    protected $casts = [
        'id' => 'integer',
        'tender_id' => 'integer',
        'file_name' => 'string',
        'file_link' => 'string'
    ];
}
