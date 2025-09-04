<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model {
    protected $fillable = [
        'numero_processo', 'nome_reu', 'cpf_cnpj_reu',
        'valor_causa', 'status', 'folder_id'
    ];

    public function folder() {
        return $this->belongsTo(Folder::class);
    }
}

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model {
    protected $fillable = ['name'];

    public function processos() {
        return $this->hasMany(Processo::class);
    }
}