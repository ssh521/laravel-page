# Laravel Page

`ssh521/laravel-page`는 `ssh521/laravel-admin`에 붙는 정적/반정적 페이지 CMS 패키지입니다. 회사소개, 이용약관, 개인정보처리방침, 정책 페이지, 안내 페이지처럼 운영자가 관리자 화면에서 수정해야 하는 페이지를 Laravel 앱에 빠르게 추가하는 것을 목표로 합니다.

관리자 화면은 `laravel-admin`의 Controller + Blade CRUD 계약을 따르고, 방문자 공개 페이지는 SEO와 캐시가 쉬운 server-rendered Blade 방식으로 렌더링합니다.

## 요구 사항

- PHP `^8.3`
- Laravel `^13.0`
- `ssh521/laravel-admin` `^1.0`
- `ssh521/laravel-file` `^1.0`

## 주요 기능

- 페이지 CRUD
- 페이지 타입: `page`, `landing`, `terms`, `privacy`, `policy`
- 공개 상태: `draft`, `published`, `hidden`
- 공개 URL: `/pages/{slug}`
- root slug와 alias route 설정 지원
- HTML 본문 저장
- SEO meta title, description, canonical URL, OG metadata
- 약관/정책 버전 저장 및 공개
- `laravel-admin` 관리자 메뉴/권한 seeder
- `laravel-admin-ui` 레이아웃 기반 관리자 화면

## 설치

### Composer

일반 설치:

```bash
composer require ssh521/laravel-page
```

로컬 개발 path repository를 사용할 때는 앱의 `composer.json`에 저장소를 추가합니다.

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../packages/ssh521/laravel-page",
            "options": {
                "symlink": true
            }
        }
    ],
    "require": {
        "ssh521/laravel-page": "^1.0"
    }
}
```

```bash
composer update ssh521/laravel-page --with-all-dependencies
```

### Install Command

```bash
php artisan laravel-page:install
```

옵션:

```bash
php artisan laravel-page:install --publish-config
php artisan laravel-page:install --publish-views
php artisan laravel-page:install --publish-seeders
php artisan laravel-page:install --skip-migrate
php artisan laravel-page:install --skip-seed
```

`laravel-admin` 메뉴와 권한 테이블이 준비되어 있으면 install command가 페이지 관리자 메뉴와 권한을 등록합니다.

수동으로 실행하려면:

```bash
php artisan db:seed --class="Ssh521\\LaravelPage\\Database\\Seeders\\LaravelPageAdminMenuSeeder"
```

## Publish Tags

```bash
php artisan vendor:publish --tag=laravel-page-config
php artisan vendor:publish --tag=laravel-page-migrations
php artisan vendor:publish --tag=laravel-page-views
php artisan vendor:publish --tag=laravel-page-seeders
```

## URL

### 공개 페이지

| 경로 | 설명 |
|------|------|
| `/pages/{slug}` | 공개 페이지 상세 |

### 관리자 페이지

관리자 prefix는 `config('laravel-admin.route_prefix', 'admin')`와 `config('laravel-page.prefix.admin', 'pages')`를 조합합니다.

| 경로 | Route name | 설명 |
|------|------------|------|
| `/admin/pages` | `page.admin.dashboard` | 페이지 대시보드 |
| `/admin/pages/list` | `page.admin.pages.index` | 페이지 목록 |
| `/admin/pages/create` | `page.admin.pages.create` | 페이지 등록 |
| `/admin/pages/{page}` | `page.admin.pages.show` | 페이지 상세 |
| `/admin/pages/{page}/edit` | `page.admin.pages.edit` | 페이지 수정 |
| `/admin/pages/{page}/versions` | `page.admin.versions.index` | 버전 이력 |

## 권한

관리자 route는 Spatie permission 기반 `can:*` 미들웨어를 사용합니다.

| 권한 | 설명 |
|------|------|
| `laravel-page-dashboard-access` | 페이지 대시보드 접근 |
| `laravel-page-pages-view` | 페이지 조회 |
| `laravel-page-pages-create` | 페이지 생성 |
| `laravel-page-pages-update` | 페이지 수정 |
| `laravel-page-pages-delete` | 페이지 삭제 |
| `laravel-page-terms-publish` | 약관/정책 버전 공개 |

`Super Admin`은 `laravel-admin`의 Gate before 정책에 따라 모든 권한을 통과합니다.

## 설정

설정 파일은 `config/laravel-page.php`로 publish할 수 있습니다.

```php
return [
    'prefix' => [
        'web' => 'pages',
        'admin' => 'pages',
    ],

    'routes' => [
        'use_root_slugs' => false,
        'public_middleware' => ['web'],
        'aliases' => [
            // 'about' => 'company',
            // 'terms' => 'terms-of-service',
        ],
    ],

    'layout' => [
        'public' => 'laravel-page::layouts.public',
    ],

    'editor' => [
        'format' => 'html',
        'sanitize' => true,
    ],
];
```

### Root Slug

기본 공개 URL은 `/pages/{slug}`입니다.

`use_root_slugs`를 켜면 `/{slug}` 형태도 사용할 수 있지만, 호스트 앱 route와 충돌할 수 있으므로 기본값은 `false`입니다.

고정 alias가 필요하면 다음처럼 설정합니다.

```php
'aliases' => [
    'about' => 'company',
    'terms' => 'terms-of-service',
    'privacy' => 'privacy-policy',
],
```

## View 커스터마이징

전체 view publish:

```bash
php artisan vendor:publish --tag=laravel-page-views
```

복사 위치:

```text
resources/views/vendor/laravel-page
```

주요 view:

```text
admin/dashboard.blade.php
admin/pages/index.blade.php
admin/pages/create.blade.php
admin/pages/edit.blade.php
admin/pages/show.blade.php
admin/pages/partials/form.blade.php
admin/versions/index.blade.php
layouts/public.blade.php
pages/show.blade.php
pages/types/page.blade.php
pages/types/terms.blade.php
pages/types/privacy.blade.php
pages/types/policy.blade.php
pages/types/landing.blade.php
```

## 데이터 모델

| 테이블 | 설명 |
|--------|------|
| `pages` | 페이지 기본 정보, 본문, 상태, SEO metadata |
| `page_versions` | 약관/정책 버전 이력 |
| `page_sections` | v1.1 랜딩 페이지 섹션용 구조 |
| `page_media` | `laravel-file` 연동 파일 참조 구조 |

## 현재 범위와 다음 단계

현재 1차 구현 범위:

- Controller + Blade 기반 관리자 CRUD
- 공개 페이지 Blade 렌더링
- 페이지 버전 저장/공개
- `laravel-admin` 메뉴/권한 등록
- `laravel-file` 연동을 위한 파일 참조 필드

다음 단계 후보:

- `laravel-file` 파일 선택 UI 연동
- HTML sanitize 처리 고도화
- v1.1 랜딩 섹션 편집 UI
- 미리보기 URL
- 페이지 복제
- 캐시 무효화 정책 구현

## 테스트

패키지 단독 또는 test app vendor를 통해 PHPUnit을 실행합니다.

```bash
cd adminTest
./vendor/bin/phpunit --configuration ../packages/ssh521/laravel-page/phpunit.xml.dist
```

라우트 확인:

```bash
php artisan route:list --path=admin/pages
php artisan route:list --path=pages
```

마이그레이션 SQL 확인:

```bash
php artisan migrate --path=../packages/ssh521/laravel-page/database/migrations --pretend
```

## 개발 원칙

- 관리자 화면은 Controller + Blade CRUD를 기본으로 합니다.
- Livewire는 정렬, 모달, 파일 선택, 빠른 상태 변경 같은 보조 UI에만 선택적으로 사용합니다.
- 방문자 공개 페이지는 SEO와 캐시를 위해 Blade server-rendered page를 기본으로 합니다.
- 관리자 UI는 `laravel-admin-ui`의 resource pattern을 따릅니다.
