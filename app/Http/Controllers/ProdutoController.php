<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::paginate(10);
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique:produtos',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco_custo' => 'required|string',
            'preco_venda' => 'required|string',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_atual' => 'required|integer|min:0',
            'unidade_medida' => 'required|string|max:10',
            'imagem' => 'nullable|image|max:2048',
            'ativo' => 'nullable|boolean',
            'tamanhos' => 'nullable|array',
            'tamanhos.*' => 'exists:tamanhos,id',
            'precos' => 'nullable|array',
            'precos.*' => 'nullable|string',
        ]);

        // Converter valores monetários
        $validated['preco_custo'] = str_replace(['.', ','], ['', '.'], $validated['preco_custo']);
        $validated['preco_venda'] = str_replace(['.', ','], ['', '.'], $validated['preco_venda']);

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('produtos', 'public');
            $validated['imagem'] = $path;
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $produto = Produto::create($validated);

        // Salvar tamanhos e preços
        if ($request->has('tamanhos')) {
            $tamanhos = [];
            foreach ($request->tamanhos as $tamanhoId) {
                $preco = $request->precos[$tamanhoId] ?? null;
                if ($preco) {
                    $preco = str_replace(['.', ','], ['', '.'], $preco);
                }
                $tamanhos[$tamanhoId] = ['preco' => $preco];
            }
            $produto->tamanhos()->sync($tamanhos);
        }

        return redirect()->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:20|unique:produtos,codigo,' . $produto->id,
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco_custo' => 'required|string',
            'preco_venda' => 'required|string',
            'estoque_minimo' => 'required|integer|min:0',
            'estoque_atual' => 'required|integer|min:0',
            'unidade_medida' => 'required|string|max:10',
            'imagem' => 'nullable|image|max:2048',
            'ativo' => 'nullable|boolean',
            'tamanhos' => 'nullable|array',
            'tamanhos.*' => 'exists:tamanhos,id',
            'precos' => 'nullable|array',
            'precos.*' => 'nullable|string',
        ]);

        // Converter valores monetários
        $validated['preco_custo'] = str_replace(['.', ','], ['', '.'], $validated['preco_custo']);
        $validated['preco_venda'] = str_replace(['.', ','], ['', '.'], $validated['preco_venda']);

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('produtos', 'public');
            $validated['imagem'] = $path;
        }

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $produto->update($validated);

        // Salvar tamanhos e preços
        if ($request->has('tamanhos')) {
            $tamanhos = [];
            foreach ($request->tamanhos as $tamanhoId) {
                $preco = $request->precos[$tamanhoId] ?? null;
                if ($preco) {
                    $preco = str_replace(['.', ','], ['', '.'], $preco);
                }
                $tamanhos[$tamanhoId] = ['preco' => $preco];
            }
            $produto->tamanhos()->sync($tamanhos);
        } else {
            $produto->tamanhos()->detach();
        }

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
