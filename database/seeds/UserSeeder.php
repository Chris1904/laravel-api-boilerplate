<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();

        User::create([
           'email' => 'admin@admin.com',
           'password' => 'password',
        ])->assignRole('admin');

        factory(User::class, 50)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }

    /**
     * Truncate all tables related to permissions.
     *
     * @return void
     */
    public function truncate()
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();

        Schema::enableForeignKeyConstraints();
    }
}
