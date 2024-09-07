<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_number',
        'organization',
        'link',
        'start_date'
    ];

    public function files(): HasMany
    {
        return $this->hasMany(TenderFile::class);
    }

    protected $casts = [
        'id' => 'integer',
        'tender_number' => 'integer',
        'organization' => 'string',
        'link' => 'string',
        'start_date' => 'datetime:Y-m-d H:i:s'
    ];
}
