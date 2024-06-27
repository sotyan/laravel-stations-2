<?php

namespace Database\Seeders;

use App\Practice;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Schedule;
use App\Models\Sheet;
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
        Practice::factory(10)->create();
        //Movie::factory(20)->create();
        Genre::factory(20)->create();
        //Schedule::factory(3)->create();
        // Movie::factory(40)->create()->each(function ($movie){
        //     Schedule::factory(4)->create(['movie_id' => $movie->id]);
        // });
        Movie::factory(10)->has(Schedule::factory()->count(3))->create();
        $this->call(SheetTableSeeder::class); // SheetTableSeederの呼び出し

    }
}
