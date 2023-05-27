<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hebergements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('image_path')->nullable();
            $table->float('price', 8, 2);
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->float('latitude', 10, 8)->nullable();
            $table->float('longitude', 11, 8)->nullable();
            $table->boolean('is_available')->default(true);
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
        Schema::dropIfExists('hebergements');
    }
};
