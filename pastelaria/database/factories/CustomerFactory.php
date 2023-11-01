<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->cellphone(false),
            'data_nascimento' => fake()->date('d/m/Y'),
            'endereco' => fake()->streetName,
            'cep' => fake()->postcode,
            'bairro' => fake()->city
        ];
    }
}
