<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        $images = [
            'https://phonebook-files.s3.sa-east-1.amazonaws.com/contact-1.png',
            'https://phonebook-files.s3.sa-east-1.amazonaws.com/contact-2.png',
            'https://phonebook-files.s3.sa-east-1.amazonaws.com/contact-3.png',
            'https://phonebook-files.s3.sa-east-1.amazonaws.com/contact-4.png',
            'https://phonebook-files.s3.sa-east-1.amazonaws.com/contact-5.png',
        ];

        return [
            'telephone' => $faker->unique()->phoneNumberCleared(),
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'image' => $faker->randomElement($images)
        ];
    }
}
