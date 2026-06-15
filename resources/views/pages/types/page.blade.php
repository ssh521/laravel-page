<main style="max-width: 960px; margin: 0 auto; padding: 48px 20px; font-family: system-ui, sans-serif; line-height: 1.7;">
    <h1 style="font-size: 2rem; line-height: 1.2;">{{ $page->title }}</h1>
    @if($page->summary)
        <p style="margin-top: 12px; color: #4b5563;">{{ $page->summary }}</p>
    @endif
    <article style="margin-top: 32px;">
        {!! $page->body !!}
    </article>
</main>
