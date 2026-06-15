<?php

namespace Ssh521\LaravelPage\Database\Seeders;

use Illuminate\Database\Seeder;
use Ssh521\LaravelAdmin\Support\AdminPackageRegistrar;

class LaravelPageAdminMenuSeeder extends Seeder
{
    public function run(): void
    {
        $result = app(AdminPackageRegistrar::class)->register('laravel-page', [
            'category' => [
                'name' => '페이지 관리',
                'is_active' => true,
                'sort_order' => 740,
            ],
            'menus' => [
                [
                    'name' => '페이지 대시보드',
                    'route_name' => 'page.admin.dashboard',
                    'url' => '/admin/pages',
                    'sort_order' => 0,
                    'icon' => 'fas fa-file-lines',
                    'description' => '페이지 CMS 대시보드',
                ],
                [
                    'name' => '페이지 목록',
                    'route_name' => 'page.admin.pages.index',
                    'url' => '/admin/pages/list',
                    'sort_order' => 10,
                    'icon' => 'fas fa-list',
                    'description' => '회사소개, 약관, 정책 페이지 관리',
                ],
            ],
            'permissions' => [
                ['name' => 'laravel-page-dashboard-access', 'description' => '페이지 관리자 대시보드 접근', 'sort_order' => 740],
                ['name' => 'laravel-page-pages-view', 'description' => '페이지 조회', 'sort_order' => 741],
                ['name' => 'laravel-page-pages-create', 'description' => '페이지 생성', 'sort_order' => 742],
                ['name' => 'laravel-page-pages-update', 'description' => '페이지 수정', 'sort_order' => 743],
                ['name' => 'laravel-page-pages-delete', 'description' => '페이지 삭제', 'sort_order' => 744],
                ['name' => 'laravel-page-terms-publish', 'description' => '약관/정책 버전 공개', 'sort_order' => 745],
            ],
        ]);

        $this->warnMissingRoles(array_unique([
            ...$result['missing_menu_roles'],
            ...$result['missing_permission_roles'],
        ]));
    }

    /**
     * @param  array<int, string>  $roleNames
     */
    private function warnMissingRoles(array $roleNames): void
    {
        if ($roleNames !== []) {
            $this->command?->warn('laravel-admin RolePermissionSeeder를 먼저 실행하면 Page 메뉴와 권한이 기본 역할에 할당됩니다.');
        }
    }
}
