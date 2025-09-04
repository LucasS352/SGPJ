<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Processo;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 50);
        $processos = Processo::paginate($limit);

        return response()->json($processos);
    }

    public function updateStatus(Request $request, Processo $processo)
    {
        $request->validate(['status' => 'required|in:PENDENTE,APROVADO,REJEITADO']);
        $processo->update(['status' => $request->status]);

        return response()->json(['message' => 'Status atualizado com sucesso']);
    }
}