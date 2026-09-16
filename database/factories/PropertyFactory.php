<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'price' => $this->faker->randomFloat(2, 10000, 1000000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'area' => $this->faker->randomFloat(2, 500, 5000),
            'type' => $this->faker->randomElement(['house', 'apartment', 'land']),
            'purpose' => $this->faker->randomElement(['sell', 'rent']),
            'inspection_status' => $this->faker->randomElement(['Assigned', 'Scheduled', 'In Progress', 'Completed', 'Report Submitted']),
            'verification_status' => $this->faker->randomElement(['Pending', 'Under Review', 'Verified', 'Rejected']),
            'owner_type' => $this->faker->randomElement(['admin', 'vendor']),
            'is_verified' => $this->faker->boolean,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'archived_at' => null,
        ];
    }
}
