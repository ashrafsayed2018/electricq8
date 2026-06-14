<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'whatsapp_number',   'group' => 'contact', 'value' => '96512345678'],
            ['key' => 'phone_number',       'group' => 'contact', 'value' => '+965 1234 5678'],
            ['key' => 'email',              'group' => 'contact', 'value' => 'info@electricq8.com'],
            ['key' => 'google_maps_embed',  'group' => 'contact', 'value' => 'https://maps.google.com/'],
            ['key' => 'instagram_url',      'group' => 'social',  'value' => 'https://instagram.com/electricq8'],
            ['key' => 'snapchat_url',       'group' => 'social',  'value' => 'https://snapchat.com/add/electricq8'],
            ['key' => 'tiktok_url',         'group' => 'social',  'value' => 'https://tiktok.com/@electricq8'],
            ['key' => 'site_name_en',       'group' => 'seo',     'value' => 'ElectricQ8 — Electrical Services Kuwait'],
            ['key' => 'site_name_ar',       'group' => 'seo',     'value' => 'إلكتريك كويت — خدمات كهرباء الكويت'],
            ['key' => 'default_meta_en',    'group' => 'seo',     'value' => 'Electrical Repair & Installation Kuwait'],
            ['key' => 'default_meta_ar',    'group' => 'seo',     'value' => 'تركيب وإصلاح كهرباء الكويت'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
