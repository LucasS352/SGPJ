<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_processo')->nullable();
            $table->string('nome_reu')->nullable();
            $table->string('cpf_cnpj_reu')->nullable();
            $table->string('valor_causa')->nullable();
            $table->enum('status', ['PENDENTE', 'APROVADO', 'REJEITADO'])->default('PENDENTE');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('processos');
    }
};