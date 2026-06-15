<?php

return [
    'prefix' => [
        'web' => env('LARAVEL_PAGE_WEB_PREFIX', 'pages'),
        'admin' => env('LARAVEL_PAGE_ADMIN_PREFIX', 'pages'),
    ],

    'routes' => [
        'use_root_slugs' => env('LARAVEL_PAGE_ROOT_SLUGS', false),
        'public_middleware' => ['web'],
        'aliases' => [
            // 'about' => 'company',
            // 'terms' => 'terms-of-service',
            // 'privacy' => 'privacy-policy',
        ],
    ],

    'admin' => [
        'middleware' => null,
    ],

    'layout' => [
        'public' => env('LARAVEL_PAGE_PUBLIC_LAYOUT', 'laravel-page::layouts.public'),
    ],

    'editor' => [
        'format' => 'html',
        'sanitize' => true,
    ],

    'files' => [
        'driver' => 'laravel-file',
        'collection' => 'pages',
    ],

    'types' => [
        'page' => ['label' => '일반 페이지', 'sections' => false, 'versions' => false],
        'landing' => ['label' => '랜딩 페이지', 'sections' => true, 'versions' => false, 'release' => 'v1.1'],
        'terms' => ['label' => '이용약관', 'sections' => false, 'versions' => true],
        'privacy' => ['label' => '개인정보처리방침', 'sections' => false, 'versions' => true],
        'policy' => ['label' => '정책 페이지', 'sections' => false, 'versions' => true],
    ],

    'statuses' => [
        'draft' => '초안',
        'published' => '공개',
        'hidden' => '숨김',
    ],
];
