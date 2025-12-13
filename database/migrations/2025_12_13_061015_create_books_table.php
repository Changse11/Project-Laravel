<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->enum('kategori', ['Pendidikan', 'Teknologi', 'Novel', 'Agama', 'Sejarah']);
            $table->string('isbn')->unique();
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};