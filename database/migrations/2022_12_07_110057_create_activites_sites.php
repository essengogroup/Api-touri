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
        Schema::create('activites_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Activite::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Site::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('activites_sites');
    }
};
