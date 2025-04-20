<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */class CategoryFactory extends Factory
{
    protected $categories = [
        'Laptops',
        'Smartphones',
        'Tablets',
        'Desktop Computers',
        'Computer Monitors',
        'Keyboards',
        'Computer Mice',
        'Headphones',
        'Printers & Scanners',
        'Smart Watches',
        'Webcams',
        'Speakers',
        'External Hard Drives',
        'USB Flash Drives',
        'Chargers & Cables'
    ];


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement($this->categories)
        ];
    }
}
