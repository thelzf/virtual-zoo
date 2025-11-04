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
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string('species');
            $table->unsignedBigInteger('genus_id');  // Mudar para unsignedBigInteger
            $table->timestamps();

            // Definir a chave estrangeira
            $table
                ->foreign('genus_id')
                ->references('id')
                ->on('genus')  // Nome da tabela referenciada
                ->onDelete('cascade');  // Opcional: ação ao deletar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('species', function (Blueprint $table) {
            // Remover a chave estrangeira primeiro
            $table->dropForeign(['genus_id']);
        });

        Schema::dropIfExists('species');
    }
};
