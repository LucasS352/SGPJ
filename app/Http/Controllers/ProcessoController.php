<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Models\Folder;
use Illuminate\Http\Request;

class ProcessoController extends Controller {
    public function index(Request $request) {
        $search = $request->input('search');
        $tab = $request->input('tab', 'all');
        $query = Processo::query();

        if ($search) {
            $query->where('nome_reu', 'like', "%$search%")
                  ->orWhere('numero_processo', 'like', "%$search%");
        }

        if ($tab !== 'all') {
            $query->whereBetween('valor_causa', match ($tab) {
                '100-300' => [100000, 300000],
                '300-500' => [300000, 500000],
                '500+' => [500000, 999999999],
                default => [0, 999999999],
            });
        }

        $processos = $query->orderBy('valor_causa', 'desc')->paginate(10);
        $folders = Folder::all();

        return view('processos.index', compact('processos', 'folders', 'search', 'tab'));
    }

    public function updateStatus(Processo $processo, Request $request) {
        $processo->update(['status' => $request->status]);
        return back()->with('success', 'Status atualizado!');
    }

    public function assignToFolder(Request $request, Folder $folder) {
        Processo::whereIn('id', $request->processo_ids)->update(['folder_id' => $folder->id]);
        return back()->with('success', 'Processos adicionados à pasta!');
    }
}