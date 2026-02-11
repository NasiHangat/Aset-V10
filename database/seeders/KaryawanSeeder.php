<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('employees')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'jabatan' => $faker->randomElement(['Karyawan', 'Operator']),
                'nip' => $faker->unique()->randomNumber(5),
                'alamat' => $faker->address,
                'gender' => $faker->randomElement(['L', 'P']),
                'phone_number' => $faker->phoneNumber,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}