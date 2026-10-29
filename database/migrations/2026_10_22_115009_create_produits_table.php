
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')
                  ->constrained('categories')
                  ->cascadeOnDelete();

            $table->string('nom', 150);
            $table->text('description')->nullable();
            $table->decimal('prix', 12, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->string('unite', 30)->default('pièce');
            $table->string('image')->nullable();
            $table->boolean('actif')->default(true);
            $table->unsignedInteger('nombre_recherches')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
