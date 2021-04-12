<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $date = Carbon::now()->subDays(rand(1, 28))->subMonth(rand(1, 12));

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => app('hash')->make('123456'),
            'email_verified_at' => Carbon::parse($date)->addHour(rand(1, 12)),
            'createdAt'  => $date,
            'updatedAt'  => Carbon::parse($date)->addDay(rand(1, 28))->addHour(rand(1, 12))
        ];
    }
}
