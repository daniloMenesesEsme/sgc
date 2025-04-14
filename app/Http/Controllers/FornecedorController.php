<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fornecedor::query();
        
        // Filtro de busca
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome_razao_social', 'like', "%{$search}%")
                  ->orWhere('nome_fantasia', 'like', "%{$search}%")
                  ->orWhere('cpf_cnpj', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filtro por tipo (PF ou PJ)
        if ($request->has('tipo') && !empty($request->tipo)) {
            $query->where('tipo', $request->tipo);
        }
        
        // Filtro por material fornecido
        if ($request->has('material') && !empty($request->material)) {
            switch ($request->material) {
                case 'tecido':
                    $query->where('fornece_tecido', true);
                    break;
                case 'tinta':
                    $query->where('fornece_tinta', true);
                    break;
                case 'papel':
                    $query->where('fornece_papel', true);
                    break;
                case 'outros':
                    $query->where('fornece_outros', true);
                    break;
            }
        }
        
        // Filtro por status (ativo/inativo)
        if ($request->has('status')) {
            if ($request->status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($request->status === 'inativo') {
                $query->where('ativo', false);
            }
        } else {
            // Por padrão, mostra apenas ativos
            $query->where('ativo', true);
        }
        
        $fornecedores = $query->orderBy('nome_razao_social')->paginate(10);
        
        return view('fornecedores.index', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornecedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipo' => 'required|in:PF,PJ',
            'nome_razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cpf_cnpj' => 'required|string|max:18|unique:fornecedores',
            'inscricao_estadual' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:9',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|size:2',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'fornece_tecido' => 'nullable|boolean',
            'fornece_tinta' => 'nullable|boolean',
            'fornece_papel' => 'nullable|boolean',
            'fornece_outros' => 'nullable|boolean',
            'observacoes' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        // Trate os campos que vieram como checkbox
        $validatedData['fornece_tecido'] = $request->has('fornece_tecido') ? 1 : 0;
        $validatedData['fornece_tinta'] = $request->has('fornece_tinta') ? 1 : 0;
        $validatedData['fornece_papel'] = $request->has('fornece_papel') ? 1 : 0;
        $validatedData['fornece_outros'] = $request->has('fornece_outros') ? 1 : 0;
        $validatedData['ativo'] = $request->has('ativo') ? 1 : 0;
        
        // Preencha os campos não usados no formulário com valores padrão
        $validatedData['rg_ie'] = $validatedData['inscricao_estadual'] ?? null;
        unset($validatedData['inscricao_estadual']);
        $validatedData['im'] = null;
        $validatedData['celular'] = null;
        $validatedData['site'] = null;
        $validatedData['contato_nome'] = null;
        $validatedData['contato_email'] = null;
        $validatedData['contato_telefone'] = null;
        $validatedData['categoria'] = null;
        $validatedData['produtos_fornecidos'] = null;
        $validatedData['condicoes_pagamento'] = null;

        $fornecedor = Fornecedor::create($validatedData);

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fornecedor $fornecedor)
    {
        return view('fornecedores.show', compact('fornecedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fornecedor $fornecedor)
    {
        return view('fornecedores.edit', compact('fornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $validatedData = $request->validate([
            'tipo' => 'required|in:PF,PJ',
            'nome_razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'cpf_cnpj' => [
                'required',
                'string',
                'max:18',
                Rule::unique('fornecedores')->ignore($fornecedor->id),
            ],
            'inscricao_estadual' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:9',
            'logradouro' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|size:2',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'fornece_tecido' => 'nullable|boolean',
            'fornece_tinta' => 'nullable|boolean',
            'fornece_papel' => 'nullable|boolean',
            'fornece_outros' => 'nullable|boolean',
            'observacoes' => 'nullable|string',
            'ativo' => 'nullable|boolean',
        ]);

        // Trate os campos que vieram como checkbox
        $validatedData['fornece_tecido'] = $request->has('fornece_tecido') ? 1 : 0;
        $validatedData['fornece_tinta'] = $request->has('fornece_tinta') ? 1 : 0;
        $validatedData['fornece_papel'] = $request->has('fornece_papel') ? 1 : 0;
        $validatedData['fornece_outros'] = $request->has('fornece_outros') ? 1 : 0;
        $validatedData['ativo'] = $request->has('ativo') ? 1 : 0;
        
        // Mapeie inscricao_estadual para rg_ie
        $validatedData['rg_ie'] = $validatedData['inscricao_estadual'] ?? null;
        unset($validatedData['inscricao_estadual']);

        $fornecedor->update($validatedData);

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')
            ->with('success', 'Fornecedor excluído com sucesso!');
    }
    
    /**
     * Busca os dados do CNPJ na API e retorna os dados para preenchimento automático
     */
    public function buscaCnpj(Request $request)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $request->cnpj);
        
        if (strlen($cnpj) != 14) {
            return response()->json([
                'status' => 'error',
                'message' => 'CNPJ inválido'
            ], 400);
        }
        
        try {
            // Tentar com a API Brasil (recomendada por ser gratuita e sem limites de uso)
            $response = Http::get("https://brasilapi.com.br/api/cnpj/v1/{$cnpj}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'status' => 'success',
                    'razao_social' => $data['razao_social'] ?? '',
                    'nome_fantasia' => $data['nome_fantasia'] ?? '',
                    'cep' => $data['cep'] ?? '',
                    'logradouro' => $data['logradouro'] ?? '',
                    'numero' => $data['numero'] ?? '',
                    'complemento' => $data['complemento'] ?? '',
                    'bairro' => $data['bairro'] ?? '',
                    'municipio' => $data['municipio'] ?? '',
                    'uf' => $data['uf'] ?? '',
                    'telefone' => $data['ddd_telefone_1'] ? '(' . substr($data['ddd_telefone_1'], 0, 2) . ') ' . 
                                   substr($data['ddd_telefone_1'], 2) : '',
                    'email' => $data['email'] ?? '',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'CNPJ não encontrado na base de dados'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao buscar CNPJ: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Busca os dados do CEP na API e retorna para preenchimento automático
     */
    public function buscaCep(Request $request)
    {
        $cep = preg_replace('/[^0-9]/', '', $request->cep);
        
        if (strlen($cep) != 8) {
            return response()->json([
                'status' => 'error',
                'message' => 'CEP inválido'
            ], 400);
        }
        
        try {
            // Tenta buscar na API viacep
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
            
            if ($response->successful() && !isset($response['erro'])) {
                $data = $response->json();
                
                return response()->json([
                    'status' => 'success',
                    'logradouro' => $data['logradouro'] ?? '',
                    'complemento' => $data['complemento'] ?? '',
                    'bairro' => $data['bairro'] ?? '',
                    'cidade' => $data['localidade'] ?? '',
                    'uf' => $data['uf'] ?? ''
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'CEP não encontrado'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao buscar CEP: ' . $e->getMessage()
            ], 500);
        }
    }
} 