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

    'templates' => [
        'company' => [
            'label' => '회사소개',
            'type' => 'page',
            'title' => '회사소개',
            'slug' => 'about',
            'summary' => '회사의 가치와 서비스를 소개합니다.',
            'body' => <<<'HTML'
<h2>회사소개</h2>
<p>여기에 회사의 소개 문구를 입력하세요.</p>
<h2>우리가 하는 일</h2>
<p>주요 서비스, 제품, 운영 철학을 간단히 정리하세요.</p>
HTML,
            'meta_title' => '회사소개',
            'meta_description' => '회사 소개와 주요 서비스를 확인하세요.',
        ],
        'terms' => [
            'label' => '이용약관',
            'type' => 'terms',
            'title' => '이용약관',
            'slug' => 'terms',
            'summary' => '서비스 이용약관입니다.',
            'body' => <<<'HTML'
<h2>제1조 목적</h2>
<p>이 약관은 서비스 이용 조건과 절차를 정하는 것을 목적으로 합니다.</p>
<h2>제2조 정의</h2>
<p>이 약관에서 사용하는 용어의 정의를 입력하세요.</p>
HTML,
            'meta_title' => '이용약관',
            'meta_description' => '서비스 이용약관을 확인하세요.',
        ],
        'privacy' => [
            'label' => '개인정보처리방침',
            'type' => 'privacy',
            'title' => '개인정보처리방침',
            'slug' => 'privacy',
            'summary' => '개인정보 처리 기준과 보호 조치를 안내합니다.',
            'body' => <<<'HTML'
<h2>개인정보의 처리 목적</h2>
<p>개인정보를 처리하는 목적을 입력하세요.</p>
<h2>처리하는 개인정보 항목</h2>
<p>수집 및 처리하는 개인정보 항목을 입력하세요.</p>
HTML,
            'meta_title' => '개인정보처리방침',
            'meta_description' => '개인정보 처리 기준과 보호 조치를 확인하세요.',
        ],
        'policy' => [
            'label' => '운영 정책',
            'type' => 'policy',
            'title' => '운영 정책',
            'slug' => 'policy',
            'summary' => '서비스 운영 정책을 안내합니다.',
            'body' => <<<'HTML'
<h2>기본 원칙</h2>
<p>서비스 운영 원칙을 입력하세요.</p>
<h2>제한 행위</h2>
<p>제한되거나 금지되는 행위를 입력하세요.</p>
HTML,
            'meta_title' => '운영 정책',
            'meta_description' => '서비스 운영 정책을 확인하세요.',
        ],
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
