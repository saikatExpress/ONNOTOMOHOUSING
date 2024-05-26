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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('amount')->nullable();
            $table->string('bank_slip', 500)->nullable();
            $table->string('status', 50)->default('1')->nullable();
            $table->integer('is_pending')->default(0)->nullable();
            $table->integer('is_cancel')->default(0)->nullable();
            $table->integer('is_approve')->default(0)->nullable();
            $table->integer('flag')->default(0)->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->unsignedBigInteger('cancel_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
