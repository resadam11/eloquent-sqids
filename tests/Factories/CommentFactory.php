<?php

namespace ErikSulymosi\EloquentSqids\Tests\Factories;

use ErikSulymosi\EloquentSqids\Tests\Models\Comment;
use ErikSulymosi\EloquentSqids\Tests\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
 
class CommentFactory extends Factory
{
	/**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Comment::class;
	
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		return [
			'body' => fake()->paragraph(),
			'item_id' => fn () => Item::factory()->create(),
		];
	}
}
