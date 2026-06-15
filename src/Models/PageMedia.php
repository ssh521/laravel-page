<?php

namespace Ssh521\LaravelPage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageMedia extends Model
{
    protected $table = 'page_media';

    protected $fillable = [
        'page_id',
        'section_id',
        'file_id',
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'alt',
        'sort_order',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(PageSection::class, 'section_id');
    }
}
