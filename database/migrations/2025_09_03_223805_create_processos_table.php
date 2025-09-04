<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('processos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_processo');
            $table->string('nome_reu');
            $table->string('cpf_cnpj_reu')->nullable();
            $table->decimal('valor_causa', 15, 2)->default(0);
            $table->enum('status', ['PENDENTE', 'APROVADO', 'REJEITADO'])->default('PENDENTE');
            $table->foreignId('folder_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('processos');
        Schema::dropIfExists('folders');
    }
};