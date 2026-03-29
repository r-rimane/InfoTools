<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Produit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
         $categories = ['chaussures', 'vetements', 'accessoires'];


        return [
            'nom' => $this->faker->words(2, true),
            'description' => $this->faker->sentence(),
            'catégorie' => $this->faker->randomElement($categories),
            'image' => $this->faker->imageUrl(400, 400, 'technics', true), // génère une image aléatoire
            'prix' => $this->faker->randomFloat(2, 1, 500), // prix entre 1 et 500
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
