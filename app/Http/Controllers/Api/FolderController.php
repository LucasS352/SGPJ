<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function index()
    {
        return Folder::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        return Folder::create($data);
    }

    public function show(Folder $folder)
    {
        return $folder;
    }

    public function update(Request $request, Folder $folder)
    {
        $data = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
        ]);

        $folder->update($data);

        return $folder;
    }

    public function destroy(Folder $folder)
    {
        $folder->delete();
        return response()->noContent();
    }
}