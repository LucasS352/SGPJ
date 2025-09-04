<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    protected $fillable = [
        'numero_processo',
        'nome_reu',
        'cpf_cnpj_reu',
        'valor_causa',
        'status'
    ];

    public function folders() {
        return $this->belongsToMany(Folder::class, 'folder_process_association', 'processo_id', 'folder_id')
                    ->withPivot('observation');
    }

    public function getValorCausaFloatAttribute()
    {
        $valor = str_replace(['R$', '.', ' '], '', $this->valor_causa);
        $valor = str_replace(',', '.', $valor);
            return (float)$valor;
    }
}