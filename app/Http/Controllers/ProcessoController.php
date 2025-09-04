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
        $tab = $request->input('tab', 'all');
        $sort = $request->input('sort', 'valor_causa');
        $direction = $request->input('direction', 'desc');

        $query = Processo::query();

        if ($tab === '100-300') {
            $query->whereBetween('valor_causa', [100000, 300000]);
        } elseif ($tab === '300-500') {
            $query->whereBetween('valor_causa', [300000, 500000]);
        } elseif ($tab === '500+') {
            $query->where('valor_causa', '>=', 500000);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_reu', 'like', "%{$search}%")
                  ->orWhere('numero_processo', 'like', "%{$search}%");
            });
        }

        $processos = $query->orderBy($sort, $direction)->paginate(10)->withQueryString();

        $folders = Folder::all();

        return view('processos.index', compact('processos', 'search', 'tab', 'sort', 'direction', 'folders'));
    }

    public function updateStatus(Request $request, Processo $processo)
    {
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