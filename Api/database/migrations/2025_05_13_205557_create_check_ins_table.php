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
        Schema::create('check_ins', function (Blueprint $table) {
            $table->ulid()->primary();
            $table->time('check_in_time')->comment('Hora de entrada');
            $table->time('check_out_time')->comment('Hora de saída');
            $table->date('check_date')->comment('Data do registro de ponto');
            $table->foreignUlid('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'check_date'], 'unique_user_check_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
