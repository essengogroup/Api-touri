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
        Schema::create('reservation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\EventTouri::class)->constrained()->cascadeOnDelete();
            $table->integer('nb_persons')->default(1);
            $table->enum('status', ['pending', 'accepted', 'refused', 'canceled', 'paid'])->default('pending');
            $table->text('commentaire')->nullable();
            $table->float('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down():void
    {
        Schema::dropIfExists('reservation_events');
    }
};
