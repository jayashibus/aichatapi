<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Invoice;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'total_spent' => $this->faker->numberBetween(90, 500),
            'total_saving' => $this->faker->numberBetween(90, 500),
            'transaction_at' => $this->faker->dateTimeThisMonth(), 
        ];
    }
}
