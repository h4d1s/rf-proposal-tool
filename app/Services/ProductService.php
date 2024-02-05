<?php

namespace App\Services;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class ProductService
{
    private $url = 'https://www.rhodiumfloors.com/wp-json/wp/v2';

    private $per_page = 20;

    private function parse_response_images($response)
    {
        $image_urls = [];

        foreach ($response as $image) {
            $image_urls[] = $image['source_url'];
        }

        return $image_urls;
    }

    private function parse_response($response)
    {
        $products = [];

        foreach ($response['body'] as $product) {
            $id = $product['id'];
            $image_urls = $this->fetch_image_urls($id);
            $products[] = [
                'rf_id' => $id,
                'name' => $product['title']['rendered'],
                'description' => strip_tags($product['content']['rendered']),
                'images' => $image_urls,
            ];
        }

        return $products;
    }

    private function fetch_image_urls($parent_id)
    {
        $response = Http::get("{$this->url}/media", [
            'parent' => $parent_id,
            'media_type' => 'image',
            '_fields' => 'source_url'
        ]);

        if ($response->failed()) {
            throw new \ErrorException('Error found');
        }

        return $this->parse_response_images($response->json());
    }

    private function calculatePerPage($amount)
    {
        $per_page = $this->per_page;
        if ($amount <= $per_page) {
            $per_page = $amount;
        }

        return $per_page;
    }

    public function calculatePageCount($amount)
    {
        $per_page = $this->per_page;
        $page_count = ceil($amount / $per_page);

        if ($amount <= $per_page) {
            $page_count = 1;
        }

        return $page_count;
    }

    public function fetch()
    {
        $response = Http::get("{$this->url}/product", [
            '_envelope' => '',
            'per_page' => 1,
            'page' => 1,
            '_fields' => 'id'
        ]);
        $total_items = 20; $response->json("headers.X-WP-Total");
        $per_page = $this->calculatePerPage($total_items);
        $page_count = $this->calculatePageCount($total_items);

        $responses = Http::pool(function (Pool $pool) use ($per_page, $page_count) {
            return collect()
                ->range(1, $page_count)
                ->map(fn ($page) => $pool->get("{$this->url}/product", [
                    '_envelope' => '',
                    'per_page' => $per_page,
                    'page' => $page,
                    '_fields' => 'id,name,title,content'
                ]));
        });
        
        $products = [];
        foreach($responses as $response) {
            $products = array_merge(
                $products,
                $this->parse_response($response->json())
            );
        }
        return collect($products);
    }
}
