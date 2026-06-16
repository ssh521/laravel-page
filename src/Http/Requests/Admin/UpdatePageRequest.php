<?php

namespace Ssh521\LaravelPage\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $pageId = $this->route('page')?->getKey();

        return [
            'type' => ['required', 'string', Rule::in(array_keys(config('laravel-page.types', [])))],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('pages', 'slug')->ignore($pageId)],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(array_keys(config('laravel-page.statuses', [])))],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'template' => ['nullable', 'string', Rule::in(array_keys(config('laravel-page.templates', [])))],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string'],
            'og_image_file_id' => ['nullable', 'integer', 'min:1'],
            'og_image_path' => ['nullable', 'string', 'max:255'],
        ];
    }
}
