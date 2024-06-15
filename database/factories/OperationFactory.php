<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operation>
 */
class OperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receiverName' => null,
            'dischangeNumber' => null,
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'type' => 'وارد',
            'foulType' => 'سولار',
            'sub_consumer_id' => null,
        ];
    }
}
