<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seed_types', function (Blueprint $table) {
            $table->increments('id_seed_type');
            $table->unsignedInteger('id_item')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('cares_per_level');
            $table->integer('harvest_reward');
            $table->timestamps();

            $table->foreign('id_item')
                ->references('id_item')
                ->on('items')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seed_types');
    }
};