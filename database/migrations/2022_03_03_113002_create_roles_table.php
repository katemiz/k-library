<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {

            $table->id();
            $table->integer('category');
            $table->text('title_en');
            $table->text('title_tr');
            $table->text('desc_en')->nullable();
            $table->text('desc_tr')->nullable();
            $table->text('experience')->nullable();
            $table->text('desc_en_text')->nullable();
            $table->text('desc_tr_text')->nullable();
            $table->text('experience_text')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
