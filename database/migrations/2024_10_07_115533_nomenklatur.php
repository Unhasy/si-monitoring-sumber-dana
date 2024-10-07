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
        Schema::create('master_nomenklatur', function (Blueprint $table) {
            $table->id();
            $table->integer('master_dasar_hukum_id');
            $table->string('kategori');
            $table->string('kode_rekening');
            $table->text('nomenklatur');
            $table->integer('user_pembuat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_nomenklatur');
    }
};
