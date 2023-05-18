<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_activites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Activite::class)->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('path');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->boolean('is_main')->default(false);
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
        Schema::dropIfExists('media_activites');
    }
};
