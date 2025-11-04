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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('orders');
            $table->unsignedBigInteger('class_id');  // Mudar para unsignedBigInteger
            $table->timestamps();

            // Definir a chave estrangeira
            $table
                ->foreign('class_id')
                ->references('id')
                ->on('classes')  // Nome da tabela referenciada
                ->onDelete('cascade');  // Opcional: ação ao deletar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remover a chave estrangeira primeiro
            $table->dropForeign(['class_id']);
        });

        Schema::dropIfExists('orders');
    }
};
