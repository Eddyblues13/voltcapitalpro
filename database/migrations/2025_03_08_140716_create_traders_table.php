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
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('picture_url')->nullable();
            $table->string('picture_public_id')->nullable();
            $table->boolean('is_verified')->default(true);
            $table->string('verified_badge')->nullable();
            $table->string('name');
            $table->decimal('min_portfolio', 15, 2);
            $table->string('experience')->nullable();
            $table->string('percentage')->nullable();
            $table->string('currency_pairs')->nullable();
            $table->string('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traders');
    }
};
