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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('reference')->unique()->nullable(false);
            $table->string('name', 30)->unique()->nullable(false);
            $table->string('description');
            $table->float('purchase_price');
            $table->float('sale_price')->nullable(true);
            $table->unsignedBigInteger('id_cat_fk');
            $table->foreign('id_cat_fk')->references('id')->on('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->string('photo')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
