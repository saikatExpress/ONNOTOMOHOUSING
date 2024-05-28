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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profile_image', 250)->nullable();
            $table->string('name', 250)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('whatsapp', 25)->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('country', 200)->nullable();
            $table->string('state', 250)->nullable();
            $table->string('city', 250)->nullable();
            $table->unsignedBigInteger('total_deposite_balance')->nullable();
            $table->bigInteger('current_balance')->nullable();
            $table->string('debit_reason', 550)->nullable();
            $table->string('password');
            $table->string('user_agent', 250)->nullable();
            $table->string('otp', 150)->nullable();
            $table->string('role', 100)->default('user')->nullable();
            $table->string('status', 20)->default('1')->nullable();
            $table->integer('flag')->default(0)->nullable();
            $table->integer('is_paid')->default(0)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
