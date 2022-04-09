<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::withoutEvents(function () {
     
            Language::create([
                "title" =>'English',
                "remarks" => '<p>English as second foreign language</p>',
                "remarks_text" => 'English as second foreign language',
                "created_by" => '1'
            ]);

            Language::create([
                "title" =>'French',
                "remarks" => '<p>French as second foreign language</p>',
                "remarks_text" => 'French as second foreign language',
                "created_by" => '1'
            ]);

            Language::create([
                "title" =>'German',
                "remarks" => '<p>German as second foreign language</p>',
                "remarks_text" => 'German as second foreign language',
                "created_by" => '1'
            ]);
        });
    }
}
