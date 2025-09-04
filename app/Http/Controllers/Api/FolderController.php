<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Processo;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
        return Folder::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        $folder = Folder::create($data);

        return response()->json($folder, 201);
    }

    public function show(Request $request, Folder $folder)
    {
        $limit = $request->input('limit', 10);
        $skip = $request->input('skip', 0);

        $processos = $folder->processos()->skip($skip)->take($limit)->get();
        $total = $folder->processos()->count();

        return response()->json([
            'id' => $folder->id,
            'name' => $folder->name,
            'total_processos_count' => $total,
            'processo_associations' => $processos->map(function ($p) {
                return [
                    'processo' => $p,
                    'observation' => $p->pivot->observation ?? null,
                ];
            }),
        ]);
    }

    public function addProcessos(Request $request, Folder $folder)
    {
        $request->validate(['processo_ids' => 'required|array']);
        $folder->processos()->syncWithoutDetaching($request->processo_ids);

        return response()->json(['message' => 'Processos adicionados com sucesso']);
    }

    public function updateProcesso(Request $request, Folder $folder, Processo $processo)
    {
        $request->validate(['observation' => 'nullable|string']);
        $folder->processos()->updateExistingPivot($processo->id, [
            'observation' => $request->observation
        ]);

        return response()->json(['message' => 'Observação atualizada']);
    }

    public function removeProcesso(Folder $folder, Processo $processo)
    {
        $folder->processos()->detach($processo->id);

        return response()->json(['message' => 'Processo removido da pasta']);
    }
}