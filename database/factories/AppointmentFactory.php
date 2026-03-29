<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointment;
use App\Models\Prospect;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(8),
            'date_heure' => $this->faker->dateTimeBetween('now', '+1 month'),
            'lieu' => $this->faker->address,
            'prospect_id' => Prospect::factory(), // associe automatiquement un prospect
        ];
    }
}
