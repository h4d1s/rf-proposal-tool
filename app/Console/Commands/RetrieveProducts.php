<?php

namespace App\Console\Commands;

use App\Models\Image;
use App\Models\Product;
use App\Models\Team;
use App\Services\ProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RetrieveProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retrieve:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrives the products from Rhodium Floors';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Retriving products...');
        $products = app(ProductService::class)->fetch();

        $this->line('Saving products...');
        foreach($products as $product) {
            if (!Product::where('rf_id', $product['rf_id'])->exists()) {
                $new_products = [];

                // save product

                foreach (Team::all() as $team) {
                    $new_product = Product::make([
                        'rf_id' => $product['rf_id'],
                        'name' => $product['name'],
                        'description' => $product['description']
                    ]);

                    try {
                        $new_product->save();
                    } catch(\Exception $e) {
                        report($e);
                    }
                    $new_product->team()->associate($team)->save();
                    $new_products[] = $new_product;
                }

                // download image and save

                foreach ($product['images'] as $image_url) {
                    $contents = file_get_contents($image_url);
                    $file_basename = pathinfo($image_url, PATHINFO_BASENAME);
                    $storage_path = "public/images/products/{$product['rf_id']}";
                    $file_path = "{$storage_path}/{$file_basename}";

                    Storage::put($file_path, $contents);
                    $file_path = "products/{$product['rf_id']}/{$file_basename}";

                    foreach ($new_products as $new_product) {
                        $image = Image::make([
                            "path" => $file_path
                        ]);
                        $image->imageable()->save($new_product);
                        $image->save();
                    }
                }
            }
        }

        $this->info('Successfully retrieved!');
    }
}
