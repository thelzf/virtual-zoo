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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('families');
            $table->unsignedBigInteger('order_id');  // Mudar para unsignedBigInteger
            $table->timestamps();

            // Definir a chave estrangeira
            $table
                ->foreign('order_id')
                ->references('id')
                ->on('orders')  // Nome da tabela referenciada
                ->onDelete('cascade');  // Opcional: ação ao deletar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            // Remover a chave estrangeira primeiro
            $table->dropForeign(['order_id']);
        });

        Schema::dropIfExists('families');
    }
};
