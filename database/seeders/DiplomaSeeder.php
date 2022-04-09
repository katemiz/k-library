<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diploma;

class DiplomaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Diploma::withoutEvents(function () {

            Diploma::create([
                "title" =>'Bachelor of Science (BS)',
                "remarks" => "<p>Bachelor's degree:</p><ul><li>Serves as a proof of the fundamental and practical training of the graduate in the chosen profile</li><li>Grants the right to work in the specialty </li><li>Corresponds to the level of education required for admission to the master’s.</li></ul><p><br></p>",
                "remarks_text" => '',
                "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Bachelor of Architecture (B.Arch)',
                "remarks" => "<p>Bachelor's degree:</p><ul><li>Serves as a proof of the fundamental and practical training of the graduate in the chosen profile</li><li>Grants the right to work in the specialty </li><li>Corresponds to the level of education required for admission to the master’s.</li></ul><p><br></p>",
                "remarks_text" => '',
                "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Bachelor of Arts (BA)',
                    "remarks" => "<p>Bachelor's degree:</p><ul><li>Serves as a proof of the fundamental and practical training of the graduate in the chosen profile</li><li>Grants the right to work in the specialty </li><li>Corresponds to the level of education required for admission to the master’s.</li></ul><p><br></p>",
                    "remarks_text" => '',
                    "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Master of Science (BS)',
                "remarks" => "<p>Master's Degree will:</p><ul><li>Indicate that the student has gained deeper knowledge in the chosen profile;</li><li>Give the opportunity to engage in scientific activities or enter doctoral studies (graduate school).</li></ul><p><br></p>",
                "remarks_text" => '',
                "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Master of Architecture (B.Arch)',
                "remarks" => "<p>Master's Degree will:</p><ul><li>Indicate that the student has gained deeper knowledge in the chosen profile;</li><li>Give the opportunity to engage in scientific activities or enter doctoral studies (graduate school).</li></ul><p><br></p>",
                "remarks_text" => '',
                "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Master of Arts (MA)',
                "remarks" => "<p>Master's Degree will:</p><ul><li>Indicate that the student has gained deeper knowledge in the chosen profile;</li><li>Give the opportunity to engage in scientific activities or enter doctoral studies (graduate school).</li></ul><p><br></p>",
                "remarks_text" => '',
                "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Master of Business Administration (MBA)',
                "remarks" => "<p>MBA programs generally cover the foundations of general management</p>",
                "remarks_text" => '',
                "created_by" => '1'
            ]);

            Diploma::create([
                "title" =>'Doctor of Philosophy - (PhD)',
                "remarks" => '<ul><li>Grants the opportunity to engage in scientific (research) work, to teach in universities or to start an academic career</li><li>Serves as a proof of the deep knowledge and high qualifications in the selected field.</li></ul>',
                "remarks_text" => '',
                "created_by" => '1'
            ]);
        });
    }
}




