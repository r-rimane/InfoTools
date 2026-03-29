<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id(); // id auto-incrémenté par Laravel
            $table->string('nom');
            $table->string('image');
            $table->text('description')->nullable();
            $table->text('catégorie')->nullable();
            $table->decimal('prix', 10, 2); // prix avec 2 décimales
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};

