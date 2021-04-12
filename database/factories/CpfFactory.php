<?php

namespace Database\Factories;

use App\Models\Cpf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CpfFactory extends Factory
{
    protected $model = Cpf::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $date = Carbon::now()
            ->subDays(rand(1, 28))
            ->subMonths(rand(1, 12))
            ->subMinutes(rand(0, 60 * 23))
            ->subSeconds(rand(0, 60));

        return [
            'cpf' => $this->faker->unique()->cpf(false),
            'createdAt'  => $date,
            'updatedAt'  => Carbon::parse($date)->addDays(rand(1, 28))->addHours(rand(1, 12))->toDateTime()
        ];
    }
}
