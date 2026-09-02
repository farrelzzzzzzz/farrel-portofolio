<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $certs = [
            [
                'title' => 'Advanced UI/UX Masterclass & Design Systems',
                'issuer' => 'Google & Coursera',
                'date' => '2025',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800',
                'credential_url' => 'https://coursera.org'
            ],
            [
                'title' => 'Three.js & WebGL Creative Developer',
                'issuer' => 'Awwwards Academy',
                'date' => '2025',
                'image' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=800',
                'credential_url' => 'https://awwwards.com'
            ],
            [
                'title' => 'Fullstack Enterprise Architecture with Laravel',
                'issuer' => 'Laravel Certification',
                'date' => '2024',
                'image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&q=80&w=800',
                'credential_url' => 'https://laravel.com'
            ],
            [
                'title' => 'Blender 3D Modeling & PBR Shading',
                'issuer' => 'Blender Foundation',
                'date' => '2024',
                'image' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?auto=format&fit=crop&q=80&w=800',
                'credential_url' => 'https://blender.org'
            ]
        ];

        foreach ($certs as $cert) {
            Certificate::create($cert);
        }
    }
}
