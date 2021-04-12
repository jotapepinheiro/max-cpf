<?php

namespace Database\Seeders;

use App\Models\Cpf;
use App\Models\User;
use Illuminate\Database\Seeder;

class CpfsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CADATRAR E VINCULAR 50 CPFS
        Cpf::factory()->count(50)->create()->each(function($u) {
            $u->user()->associate(User::all()->random()->id)->save();
        });
    }
}
