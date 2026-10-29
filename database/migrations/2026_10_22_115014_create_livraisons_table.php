
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commande_id')
                  ->unique()
                  ->constrained('commandes')
                  ->cascadeOnDelete();

            $table->string('nom_livreur', 150)->nullable();
            $table->string('telephone_livreur', 30)->nullable();
            $table->string('adresse')->nullable();
            $table->string('statut', 30)->default('en_attente');
            $table->timestamp('date_expedition')->nullable();
            $table->timestamp('date_livraison')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};
