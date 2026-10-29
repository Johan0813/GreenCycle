<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trees', function (Blueprint $table) {
            $table->increments('id_tree');

            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_seed_type');

            $table->integer('level')->default(0);
            $table->integer('health')->default(100);
            $table->integer('progress')->default(0);
            $table->string('status')->default('ACTIVE');

            $table->timestamp('last_cared_at')->nullable();
            $table->timestamp('next_care_at')->nullable();
            $table->timestamp('last_decay_at')->nullable();
            $table->timestamp('harvested_at')->nullable();

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('id_seed_type')
                ->references('id_seed_type')
                ->on('seed_types')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trees');
    }
};