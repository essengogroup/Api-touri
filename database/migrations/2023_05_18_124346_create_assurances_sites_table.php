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
        Schema::create('assurances_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Assurance::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Site::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('assurances_sites');
    }
};
