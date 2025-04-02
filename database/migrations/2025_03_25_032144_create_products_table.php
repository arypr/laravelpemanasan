<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->text("description"); // Bisa menggunakan text jika deskripsi cukup panjang
            $table->integer("quantity"); // Diganti jadi integer jika menyimpan jumlah produk
            $table->decimal("price", 10, 2); // Diganti jadi decimal untuk harga, dengan 2 angka desimal
            $table->string("created_by");
            $table->string("updated_by");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
