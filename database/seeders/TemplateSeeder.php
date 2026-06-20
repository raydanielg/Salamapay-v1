<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        Template::create([
            'name' => 'Neo',
            'slug' => 'neo',
            'description' => 'A modern, clean, and conversion-optimized payment page template with hero section, customizable colors, and dark mode support. Perfect for businesses that want a professional look.',
            'thumbnail' => null,
            'is_active' => true,
            'is_premium' => false,
            'settings' => [
                'customizable_fields' => ['color', 'accent_color', 'bg_color', 'logo', 'cover_image', 'dark_mode', 'show_logo', 'show_description', 'rounded_cards'],
                'features' => ['hero_section', 'dark_mode', 'cover_image', 'trust_badges'],
            ],
            'html_structure' => 'payment.templates.neo',
            'default_colors' => [
                'primary' => '#024938',
                'accent' => '#f9ac00',
                'background' => '#ffffff',
                'text' => '#1f2937',
            ],
            'created_by' => null,
        ]);
    }
}
