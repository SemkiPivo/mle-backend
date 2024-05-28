<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static function linkUsersToLocations(): void
    {
        foreach (User::all() as $user){
            $user->update(['location_id'=>Location::all()->random()->id]);
        }
    }

    public function definition(): array
    {
        return [
            'city' =>  fake()->city(),
            'country' => fake()->country(),
            'latitude' => fake()->randomFloat(),
            'longitude' => fake()->randomFloat(),
        ];
    }
}
