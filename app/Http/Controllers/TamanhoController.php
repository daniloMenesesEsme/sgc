<?php

namespace App\Http\Controllers;

use App\Models\Tamanho;
use Illuminate\Http\Request;

class TamanhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tamanhos = Tamanho::paginate(10);
        return view('tamanhos.index', compact('tamanhos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tamanhos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:50',
            'descricao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        Tamanho::create($validated);

        return redirect()->route('tamanhos.index')
            ->with('success', 'Tamanho cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tamanho $tamanho)
    {
        return view('tamanhos.show', compact('tamanho'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tamanho $tamanho)
    {
        return view('tamanhos.edit', compact('tamanho'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tamanho $tamanho)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:50',
            'descricao' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $tamanho->update($validated);

        return redirect()->route('tamanhos.index')
            ->with('success', 'Tamanho atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tamanho $tamanho)
    {
        $tamanho->delete();
        return redirect()->route('tamanhos.index')
            ->with('success', 'Tamanho excluído com sucesso!');
    }
}
