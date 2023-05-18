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
    public function up(): void
    {
        Schema::create('site_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Site::class)->constrained()->cascadeOnDelete();
            $table->date('date_visite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('site_dates');
    }
};
