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
            $table->foreignIdFor(\App\Models\Activite::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Site::class)->constrained()->cascadeOnDelete();
            $table->float('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('activites_sites');
    }
};
