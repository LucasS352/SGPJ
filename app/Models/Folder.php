<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['name', 'owner_id'];

    public function processos() {
        return $this->belongsToMany(Processo::class, 'folder_process_association', 'folder_id', 'processo_id')
                    ->withPivot('observation');
    }
}