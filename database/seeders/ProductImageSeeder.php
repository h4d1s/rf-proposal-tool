<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (Product::lazy() as $product) {
            $images_count = $faker->randomDigitNotNull();
            $images = [];
            for ($i = 0; $i < $images_count; $i++) {
                $image = Image::make([
                    'path' => "products/sample-product.jpg"
                ]);
                $image->imageable()->associate($product);
                $images[] = $image;
            }
            $product->images()->saveMany($images);
        }
    }
}
