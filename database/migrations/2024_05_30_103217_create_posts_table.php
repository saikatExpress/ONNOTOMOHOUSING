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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->text('content')->nullable();
            $table->string('post_link', 250)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('video', 500)->nullable();
            $table->string('created_by', 200)->nullable();
            $table->string('updated_by', 200)->nullable();
            $table->string('status', 30)->default('1')->nullable();
            $table->integer('flag')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
