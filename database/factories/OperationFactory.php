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
            'receiverName' => 'Masnour',
            'dischangeNumber' => $this->faker->numberBetween(1000 , 9999),
            'date' => $this->faker->date(),
            'description' => 'سيارات الإسعاف سيارات سيارات الإسعاف سيارات الإسعاف',
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'type' => 'صرف',
            'foulType' => 'سولار',
            'sub_consumer_id' => 1,
        ];
    }
}
