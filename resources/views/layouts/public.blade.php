<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $meta['title'] ?? $page->title }} - {{ config('app.name', 'Laravel') }}</title>
    @if($meta['description'] ?? null)
        <meta name="description" content="{{ $meta['description'] }}">
    @endif
    @if($meta['canonical_url'] ?? null)
        <link rel="canonical" href="{{ $meta['canonical_url'] }}">
    @endif
    <meta property="og:title" content="{{ $meta['og_title'] ?? $page->title }}">
    @if($meta['og_description'] ?? null)
        <meta property="og:description" content="{{ $meta['og_description'] }}">
    @endif
    @if($meta['og_image'] ?? null)
        <meta property="og:image" content="{{ $meta['og_image'] }}">
    @endif
</head>
<body>
    {{ $slot }}
</body>
</html>
