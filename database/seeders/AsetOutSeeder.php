<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AsetOutSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$faker = Faker::create();

		foreach (range(1, 10) as $index) {
			DB::table('aset_outs')->insert([
				'no_faktur' => 'MK-' . $faker->unique()->numberBetween(1000, 9999),
				'name' => $faker->word,
				'spek' => $faker->sentence,
				'qty' => $faker->numberBetween(1, 100),
				'satuan' => $faker->randomElement(['pcs', 'kg', 'm']),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
			]);
		}
	}
}
