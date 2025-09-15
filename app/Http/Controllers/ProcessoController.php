<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Models\Folder;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'valor_causa');
        $direction = $request->input('direction', 'desc');

        $query = Processo::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_reu', 'like', "%{$search}%")
                  ->orWhere('numero_processo', 'like', "%{$search}%");
            });
        }

        // Altera a paginação para exibir 20 processos por página
        $processos = $query->orderBy($sort, $direction)->paginate(20)->withQueryString();

        $folders = Folder::all();

        return view('processos.index', compact('processos', 'search', 'sort', 'direction', 'folders'));
    }

    public function updateStatus(Request $request, Processo $processo)
    {
        // Adiciona validação para garantir que o status seja um dos valores permitidos
        $request->validate([
            'status' => 'required|in:PENDENTE,APROVADO,REJEITADO'
        ]);

        $processo->update(['status' => $request->status]);
        
        return back()->with('success', 'Status atualizado com sucesso!');
    }

    public function assignToFolder(Request $request, Folder $folder)
    {
        $request->validate(['processo_ids' => 'required|array']);
        $folder->processos()->syncWithoutDetaching($request->processo_ids);

        return back()->with('success', 'Processos adicionados à pasta com sucesso!');
    }
}