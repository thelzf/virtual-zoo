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
        Schema::create('genus', function (Blueprint $table) {
            $table->id();
            $table->string('genus');
            $table->unsignedBigInteger('family_id');  // Mudar para unsignedBigInteger
            $table->timestamps();

            // Definir a chave estrangeira
            $table
                ->foreign('family_id')
                ->references('id')
                ->on('family')  // Nome da tabela referenciada
                ->onDelete('cascade');  // Opcional: ação ao deletar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('genus', function (Blueprint $table) {
            // Remover a chave estrangeira primeiro
            $table->dropForeign(['family_id']);
        });

        Schema::dropIfExists('genus');
    }
};
