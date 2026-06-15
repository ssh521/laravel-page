<?php

namespace Ssh521\LaravelPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'title',
        'subtitle',
        'body',
        'image_file_id',
        'image_path',
        'image_alt',
        'button_label',
        'button_url',
        'settings',
        'sort_order',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
