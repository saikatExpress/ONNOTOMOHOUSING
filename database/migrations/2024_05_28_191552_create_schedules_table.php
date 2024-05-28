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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('holder_id')->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->string('task_name', 1000)->nullable();
            $table->timestamp('schedule_date')->nullable();
            $table->string('remark', 1500)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_aasigned')->default(0)->nullable();
            $table->string('status', 30)->default('1')->nullable();
            $table->integer('flag')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
