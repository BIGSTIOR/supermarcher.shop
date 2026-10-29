
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commande_id')
                  ->constrained('commandes')
                  ->cascadeOnDelete();

            $table->string('mode_paiement', 30);
            $table->decimal('montant', 12, 2);
            $table->string('statut', 30)->default('en_attente');
            $table->string('reference_transaction')->nullable();
            $table->timestamp('date_paiement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
