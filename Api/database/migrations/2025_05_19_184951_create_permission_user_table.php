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
        Schema::create('permission_user', function (Blueprint $table) {
            $table->ulid('id');
            $table->foreignUlid('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->foreignUlid('permission_id')->references('id')->on('permissions')->onDelete("cascade")->onUpdate("cascade");
            $table->primary(['id','user_id', 'permission_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
    }
};
