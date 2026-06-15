@component(config('laravel-page.layout.public', 'laravel-page::layouts.public'), ['page' => $page, 'meta' => $meta])
    @includeFirst([
        "laravel-page::pages.types.{$page->type}",
        'laravel-page::pages.types.page',
    ], ['page' => $page, 'meta' => $meta])
@endcomponent
