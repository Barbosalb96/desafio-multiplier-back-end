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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_public');
            $table->string('nome_fantasia');
            $table->string('email')->unique();
            $table->string('cnpj')->unique();
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');
            $table->string('telefone');
            $table->string('area_atuacao_cnae');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
