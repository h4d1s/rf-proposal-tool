<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::lazy() as $user) {
            $image = Image::make([
                'path' => 'avatars/default-avatar.png',
            ]);
            $image->imageable()->associate($user);
            $image->save();
        }
    }
}
