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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departement_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->float('price');
            $table->float('latitude', 10, 8)->nullable();
            $table->float('longitude', 11, 8)->nullable();
            // $table->decimal('latitude', 10, 8)->nullable();
            // $table->decimal('longitude', 11, 8)->nullable();
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
        Schema::dropIfExists('sites');
    }
};
