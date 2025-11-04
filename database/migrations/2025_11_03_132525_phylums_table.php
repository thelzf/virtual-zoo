<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phylums', function (Blueprint $table) {
            $table->id();
            $table->string('phylums');
            $table->unsignedBigInteger('kingdom_id');  // Mudar para unsignedBigInteger
            $table->timestamps();

            // Definir a chave estrangeira
            $table
                ->foreign('kingdom_id')
                ->references('id')
                ->on('kingdoms')  // Nome da tabela referenciada
                ->onDelete('cascade');  // Opcional: ação ao deletar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phylum', function (Blueprint $table) {
            // Remover a chave estrangeira primeiro
            $table->dropForeign(['kingdom_id']);
        });

        Schema::dropIfExists('phylums');
    }
};
