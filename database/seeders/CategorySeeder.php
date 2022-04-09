<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::withoutEvents(function () {
     
            Category::create([
                "parent_id" => '0',
                "title_en" =>'Engineering',
                "title_tr" =>'Mühendislik',
                "desc_en" =>'<p>Engineering as a category encompasses all activities/disciplines related to all aspects of product development activities.</p><p>Engineering category includes conceptual studies, development, prototyping testing/qualification/certification but excludes all mass production activities</p>',
                "desc_tr" =>'<p>Ürün geliştirme faaliyetleri kapsamında yer alan tüm çalışmaları kapsar.</p><p>Ürün geliştirme kapsamında yapılan araştırma, tasarlama, geliştirme, prototipleme, test/kalifikasyon/sertifikasyon faaliyetlerini kapsamakla beraber, seri üretim/imalatı için gereken faaliyetleri kapsamaz</p>',
                "created_by" => '1'
            ]);


            Category::create([
                "parent_id" => '0',
                "title_en" =>'Operations',
                "title_tr" =>'Operasyonlar',
                "desc_en" =>'<p>Operations category encompasses all activities/disciplines related to designing and controlling the process of production/manufacturing</p>',
                "desc_tr" =>'<p>Bu kategori üretim/imalat sürecini tasarlamak ve kontrol etmek için gerekli disiplin/çalışmaları barındırır.</p>',
                "created_by" => '1'
            ]);



        });
    }
}





