<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\GalleryImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Service::firstOrCreate(['name' => 'Nusa Fiber 100'], [
            'category' => 'Internet fiber',
            'description' => 'Koneksi fiber stabil untuk keluarga, streaming, dan kerja dari rumah.',
            'speed' => 'Hingga 100 Mbps',
            'price' => 289000,
            'featured' => true,
        ]);

        Service::firstOrCreate(['name' => 'Nusa Fiber 300'], [
            'category' => 'Internet fiber',
            'description' => 'Bandwidth lebih lega untuk banyak perangkat dan aktivitas intensif.',
            'speed' => 'Hingga 300 Mbps',
            'price' => 489000,
            'featured' => false,
        ]);

        Service::firstOrCreate(['name' => 'Jaringan Bisnis'], [
            'category' => 'Solusi bisnis',
            'description' => 'Instalasi jaringan terkelola dengan dukungan teknis untuk operasional bisnis.',
            'speed' => 'Kustom sesuai kebutuhan',
            'price' => 750000,
            'featured' => false,
        ]);

        foreach ([
            ['title' => 'Instalasi jaringan kantor', 'category' => 'Instalasi', 'image_url' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=85'],
            ['title' => 'Tim teknis lapangan', 'category' => 'Tim kami', 'image_url' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=85'],
            ['title' => 'Infrastruktur konektivitas', 'category' => 'Infrastruktur', 'image_url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=85'],
        ] as $image) {
            GalleryImage::updateOrCreate(['title' => $image['title']], $image);
        }

        $admin = User::updateOrCreate(
            ['email' => 'admin@solusinet.id'],
            ['name' => 'Administrator', 'password' => Hash::make('SolusiNet#2026')]
        );

        $admin->forceFill(['is_admin' => true])->save();
    }
}
