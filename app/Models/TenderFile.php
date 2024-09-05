<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenderFile extends Model
{
    use HasFactory;

    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }
}
