<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientAddressSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Client::lazy() as $client) {
            $address = Address::factory()->create();
            $client->address()->associate($address)->save();
        }
    }
}
