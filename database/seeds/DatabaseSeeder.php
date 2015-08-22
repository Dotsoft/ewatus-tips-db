<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Locale;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(LocaleTableSeeder::class);

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['name' => 'John Doe', 'email' => 'user@foobar.com', 'password' => bcrypt('password')]);
    }

}

class LocaleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('locales')->delete();

        Locale::create(['subtag' => 'en', 'description' => 'English']);
        Locale::create(['subtag' => 'el', 'description' => 'Greek']);
    }

}
