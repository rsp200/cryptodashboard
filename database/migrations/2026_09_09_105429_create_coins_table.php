<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('coin_id')->unique();
            $table->string('symbol');
            $table->string('name');
            $table->string('image')->nullable();
            $table->decimal('current_price', 16, 2);
            $table->bigInteger('market_cap')->nullable();
            $table->integer('market_cap_rank')->nullable();
            $table->decimal('price_change_percentage_24h', 8, 2)->nullable();
            $table->timestamp('fetched_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coins');
    }
};
