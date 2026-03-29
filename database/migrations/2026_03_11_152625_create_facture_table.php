<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('facture', function (Blueprint $table) {
        $table->id('Id'); // Ton champ "Id" avec une majuscule comme demandé
        $table->foreignId('client_id')->constrained('client'); // Lié à ta table 'client'
        $table->foreignId('produit_id')->constrained('produit'); // Lié à ta table 'produit'
        $table->integer('quantite');
        $table->decimal('montant', 10, 2); // Pour gérer les prix (ex: 1250.50)
        $table->timestamp('date_achat'); // Ton champ "date_achat"
        $table->timestamps(); // Optionnel : crée 'created_at' et 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture');
    }
};
