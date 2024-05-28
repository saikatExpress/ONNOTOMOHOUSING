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
        Schema::create('expense_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cost_head')->constrained('categories')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('expense_id')->constrained('expenses')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('expense_date')->nullable();
            $table->unsignedBigInteger('cost_amount')->nullable();
            $table->string('remark', 1000)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_logs');
    }
};
