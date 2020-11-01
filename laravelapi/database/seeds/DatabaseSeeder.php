<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            //  配列で複数指定可能。
            [UsersTableSeeder::class]
        );
    }
}
