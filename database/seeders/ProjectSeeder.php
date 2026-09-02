<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Mobile Banking App',
                'category' => 'UI/UX Design',
                'short_description' => 'Aplikasi mobile banking yang dirancang untuk memudahkan transaksi keuangan sehari-hari dengan pengalaman yang aman dan nyaman.',
                'description' => 'Detailed case study for Mobile Banking App focusing on clean architecture, dark red aesthetic, biometric authentication, and quick financial transfers.',
                'thumbnail' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&q=80&w=800',
                'gallery' => [
                    'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&q=80&w=800'
                ],
                'status' => 'Published',
                'views' => 1200
            ],
            [
                'title' => 'Race Car 3D Model',
                'category' => '3D Design',
                'short_description' => 'Model 3D mobil balap dengan detail tinggi dibuat menggunakan Blender dan tekstur PBR.',
                'description' => 'High polygon 3D model racing car built in Blender 4.0 featuring custom red livery and realistic carbon fiber texturing.',
                'thumbnail' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800',
                'gallery' => [
                    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800'
                ],
                'status' => 'Published',
                'views' => 1500
            ],
            [
                'title' => 'Cagar Magazine Issue #12',
                'category' => 'Graphic Design',
                'short_description' => 'Desain majalah dengan tema arsitektur dan lingkungan. Membahas hubungan antara bangunan modern dengan alam sekitar.',
                'description' => 'Editorial design layout and typography for Cagar Magazine Issue #12, emphasizing sustainability and architectural marvels.',
                'thumbnail' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=800',
                'gallery' => [
                    'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=800'
                ],
                'status' => 'Published',
                'views' => 880
            ],
            [
                'title' => 'Poster Coffee Shop',
                'category' => 'Graphic Design',
                'short_description' => 'Poster promosi coffee shop dengan konsep vintage dan elegan.',
                'description' => 'Commercial poster design for artisanal coffee house, blending rich dark aesthetics with warm lighting.',
                'thumbnail' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&q=80&w=800',
                'gallery' => [
                    'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&q=80&w=800'
                ],
                'status' => 'Published',
                'views' => 760
            ],
            [
                'title' => 'Brand Animation',
                'category' => 'Animation',
                'short_description' => 'Animasi logo sinematik dengan efek partikel dan transisi mulus.',
                'description' => 'Motion graphics 3D logo reveal and brand identity animation for luxury tech brand.',
                'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800',
                'gallery' => [
                    'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800'
                ],
                'status' => 'Published',
                'views' => 980
            ]
        ];

        foreach ($projects as $proj) {
            $proj['slug'] = Str::slug($proj['title']);
            Project::create($proj);
        }
    }
}
