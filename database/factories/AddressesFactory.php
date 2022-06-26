<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Addresses>
 */
class AddressesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country' => 'Brazil',
            'address' => $this->faker->address(),
            'city'    => $this->faker->city(),
            'state'   => $this->faker->state(),
            'zip'     => $this->faker->postcode(),
        ];
    }
}
