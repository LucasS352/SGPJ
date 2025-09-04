<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Processo;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
        $folders = Folder::all();
        return view('folders.index', compact('folders'));
    }

    public function show(Folder $folder)
    {
        $processos = $folder->processos()->withPivot('observation')->get();
        return view('folders.show', compact('folder', 'processos'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Folder::create(['name' => $request->name]);

        return redirect()->route('pastas.index')->with('success', 'Pasta criada com sucesso!');
    }

    public function updateProcesso(Request $request, Folder $folder, Processo $processo)
    {
        $request->validate(['observation' => 'nullable|string']);
        $folder->processos()->updateExistingPivot($processo->id, [
            'observation' => $request->observation
        ]);

        return back()->with('success', 'Observação atualizada!');
    }

    public function removeProcesso(Folder $folder, Processo $processo)
    {
        $folder->processos()->detach($processo->id);

        return back()->with('success', 'Processo removido da pasta!');
    }
}
