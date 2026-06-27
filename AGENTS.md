# AGENTS.md

## Package Boundary

`ssh521/laravel-page` owns static and semi-static page CMS behavior for `ssh521/laravel-admin`.

It manages page CRUD, templates, SEO metadata, public page rendering, and policy/terms versioning. It does not own the admin shell, admin auth, or file manager internals.

## Source Of Truth

- Package behavior: `README.md`
- Service provider: `src/LaravelPageServiceProvider.php`
- Config and templates: `config/laravel-page.php`
- Admin views: `resources/views/admin/`
- Public views: `resources/views/pages/`
- Shared admin UI contract: `../laravel-admin-ui/docs/admin-ui-design-contract.md`
- Component catalog: `../laravel-admin-ui/docs/components.md`

## Change Rules

- Keep public page rendering separate from admin CRUD UI changes.
- Preserve page status semantics: `draft`, `published`, and `hidden`.
- Preserve versioning behavior for terms/privacy/policy pages.
- Use `x-laravel-admin::admin.*` components in admin screens before adding local UI wrappers.
- Do not rename routes, form fields, template keys, or config keys for visual-only work.

## Verification

```bash
git diff --check
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
php artisan view:cache
php artisan view:clear
```

Run the Artisan commands from `/Users/ssh521/Projects/Packagist/adminTest`.
