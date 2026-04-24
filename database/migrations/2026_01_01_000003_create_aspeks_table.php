<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspeks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aspek'); // mental, akademik, karir, sosial, spiritual
            $table->string('warna')->nullable(); // untuk donut chart
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspeks');
    }
};
