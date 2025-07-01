<?php

namespace Database\Factories;

use App\Models\PortalDesign;
use App\Models\Portal;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalDesignFactory extends Factory
{
    protected $model = PortalDesign::class;

    public function definition()
    {
        return [
            'portal_id' => Portal::factory(),
            'theme' => $this->faker->word(),
            'settings' => ['color' => 'blue'],
            'slider_images' => ['img1.jpg', 'img2.jpg'],
            'colors' => ['primary' => '#000', 'secondary' => '#fff'],
            'typography' => ['font' => 'Arial'],
            'sections' => ['home', 'about'],
            'translations' => ['es' => 'Inicio'],
        ];
    }
} 