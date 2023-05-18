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
            $table->dropForeignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\EventTouri::class, 'event_id')->constrained()->onDelete('cascade');
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
    public function down()
    {
        Schema::dropIfExists('reservation_events');
    }
};
