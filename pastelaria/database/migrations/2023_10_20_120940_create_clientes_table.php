<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 80);
            $table->string('email', 90)->unique();
            $table->string('telefone', 11);
            $table->date('data_nascimento');
            $table->string('endereco', 100);
            $table->string('complemento', 80);
            $table->string('bairro', 100);
            $table->string('cep', 8);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
