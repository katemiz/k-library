<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::withoutEvents(function () {
     
            Profession::create([
                "title" =>'Mechanical Engineer',
                "remarks" => '<p>Mechanical engineering is the application of the principles and problem-solving techniques of engineering from design to manufacturing to the marketplace for any object.</p>',
                "remarks_text" => 'Makina mühendisliği, her türlü ürün için tasarım, imalat ve pazara giden yolda mühendislik bilgilerini ve problem çözme tekniklerini uygulanmasıdır.',
                "created_by" => '1'
            ]);


        });
    }
}
 