<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSocialLinksRequest extends FormRequest
{
    public function authorize()
    {
        // Pastikan user terautentikasi dan sedang mengubah profil miliknya sendiri.
        // Jika kamu memanggil request ini tanpa route model binding, ini cukup:
        return Auth::check() && Auth::id() === $this->user()->id;
    }

    protected function prepareForValidation()
    {
        // Normalisasi URL: tambahkan scheme jika tidak ada supaya rule 'url' Laravel valid
        $links = $this->input('links', []);

        foreach ($links as $i => $link) {
            if (!empty($link['url'])) {
                $url = trim($link['url']);
                if (!preg_match('~^https?://~i', $url)) {
                    $url = 'https://' . $url;
                }
                $links[$i]['url'] = $url;
            }
        }

        $this->merge(['links' => $links]);
    }

    public function rules()
    {
        $types = [
            'instagram', 'github', 'facebook', 'linkedin', 'website',
            'twitter', 'stackoverflow', 'devto', 'codepen', 'dribbble',
            'behance', 'medium', 'kaggle', 'gitlab', 'bitbucket',
            'indeed', 'glassdoor', 'angelist', 'researchgate', 'scholar',
            'youtube', 'tiktok', 'threads', 'pinterest', 'snapchat',
            'reddit', 'telegram', 'whatsapp', 'discord', 'twitch', 'other'
        ];

        return [
            'links' => ['nullable', 'array', 'max:3'],
            'links.*.type'    => ['nullable', 'string', 'in:' . implode(',', $types)],
            'links.*.url'     => ['nullable', 'string', 'url', 'max:2048'],
            'links.*.label'   => ['nullable', 'string', 'max:100'],
            'links.*.order'   => ['nullable', 'integer', 'min:0', 'max:255'],
            'links.*.visible' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'links.max' => 'Maksimum 3 link sosial diperbolehkan.',
            'links.*.url.url' => 'URL tidak valid. Silakan masukkan url lengkap atau tanpa scheme (contoh: example.com/username).',
        ];
    }
}
