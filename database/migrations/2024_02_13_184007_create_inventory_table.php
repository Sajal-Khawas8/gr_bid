<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->foreign('category')->references('name')->on('categories')->cascadeOnUpdate()->noActionOnDelete();
            $table->enum('condition', ['new', 'old']);
            $table->integer('old_months')->nullable();
            $table->float('starting_bid');
            $table->string('location');
            $table->foreign('location')->references('name')->on('locations')->cascadeOnUpdate()->noActionOnDelete();
            $table->foreignUuid('added_by')->constrained('users', 'uuid')->cascadeOnUpdate()->noActionOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
