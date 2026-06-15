<?php

namespace Ssh521\LaravelPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageVersion extends Model
{
    protected $fillable = [
        'page_id',
        'version_label',
        'summary',
        'body',
        'meta',
        'effective_date',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'meta' => 'array',
        'effective_date' => 'date',
        'published_at' => 'datetime',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
