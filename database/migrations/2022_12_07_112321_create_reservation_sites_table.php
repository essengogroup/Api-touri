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
        Schema::create('reservation_sites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Site::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->date('date_reservation');
            $table->float('price');
            $table->integer('nb_personnes')->default(1);
            $table->boolean('is_paid')->default(false);
            $table->enum('status', ['pending', 'accepted', 'refused', 'canceled', 'paid'])->default('pending');
            $table->text('commentaire')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_sites');
    }
};
