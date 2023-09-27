<?php

namespace ErikSulymosi\EloquentSqids\Tests\Factories;

use ErikSulymosi\EloquentSqids\Tests\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
	/**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Vendor::class;
	
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => fake()->name,
		];
	}
}
