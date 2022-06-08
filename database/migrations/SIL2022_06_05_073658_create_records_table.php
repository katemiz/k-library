<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Asset;
use App\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Asset::class);
            $table->string('mimetype');
            $table->string('filename');
            $table->string('stored_as');
            $table->string('thumbnail')->nullable();
            $table->string('classification');
            $table->integer('size');
            $table->boolean('has_exif')->default(0);
            $table->string('camera')->nullable();
            $table->string('datetaken')->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('records');
    }
};
