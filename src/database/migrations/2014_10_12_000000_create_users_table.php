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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('path')->nullable();
            $table->char('postcode',8)->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();
            $table->integer('role')->default(1);
            $table->integer('point')->default(0);
            $table->string('bank')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_type')->nullable();
            $table->integer('bank_number')->nullable();
            $table->rememberToken();
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
