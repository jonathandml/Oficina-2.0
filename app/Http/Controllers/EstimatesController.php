<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Estimate;
use App\Http\Requests\StoreFormValidation;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador da classe de orçamentos com operções CRUD
 * 
 * @author Jonathan David Mendes Lopes
 * @version 1.1
 */

class EstimatesController extends Controller
{
    /**
     * Povoa a lista de orçamentos
     * 
     * @return view Retorna a tela index com a lista de orcamentos 
     */
    public function index()
    {
        $estimates = Estimate::whereNotNull('id')->latest()->paginate(5);
        return view('estimates.index', compact('estimates'));
    }
    /**
     * Pesquisa orçamentos
     * <p>
     * Primeiramente todos os dados são puxados do BD 
     * depois vão sendo filtrados de acordo com os parametros fornecidos
     * 
     * @param $request requisição que veio do formulário de busca
     * 
     * @return view retorna a tela de lista de orçamentos com os dados filtrados
     */
    public function search(Request $request)
    {
        $sellerName = $request->get('seller');
        $client  = $request->get('client'); 
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        $result = Estimate::query();
        if ($sellerName != null) {
            $sellers = User::where('name', 'like', '%' . $sellerName . '%')->pluck('id');
            $result = $result->whereIn('user_id', $sellers);
        }        
        if ($client != null) {
            $result = $result->where('client', 'like', '%' . $client . '%');
        }   
        if ($startDate != null) {
            $data = date_create($startDate);
            $result = $result->where('instant', '>=', $data);
        }
        if ($endDate != null) {
            $data = date_create($endDate);
            date_time_set($data, 23, 59);
            $result = $result->where('instant', '<=', $data);
        }
        $estimates = $result->latest()->paginate(5)->setpath('');
        
        $estimates->appends(array(
            'seller' => $request->get('seller'),
            'client' => $request->get('client'),
            'startDate' => $request->get('startDate'),
            'endDate' => $request->get('endDate')
        ));
        if (count($estimates) > 0) {
            return view('estimates.index', ['estimates' => $estimates]);
        }
        return view('estimates.index')->withMessage("Nenhum resultado encontrado");
    }
    /**
     * @method GET
     * Edita um orçamento já existente
     * <p>
     * Somente usuários logados podem realizar esta operação
     * 
     * @return view Retorna a tela de edição do orçamento selecionado
     */
    public function edit(Estimate $estimate)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('estimates.update', compact('estimate'));
    }

    /**
     * @method POST
     * Atualiza os dados de um orçamento no BD
     * <p>
     * Somente usuários logados podem realizar esta operação,
     * 
     * @param estimate O orçamento que está sendo atualizado
     * @param request A requisição é validada na classe StoreFormValidation
     * 
     * @return redirect Redireciona para a tela com a lista de orçamentos
     */
    public function update(Estimate $estimate, StoreFormValidation $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $estimate->update($request->all());
        return redirect("/orcamentos");
    }

    /**
     * @method GET
     * Cria um novo orçamentos
     * 
     * @return view retorna a tela de cadastro de um novo orçamento
     */
    public function create()
    {
        return view('estimates.create');
    }
    /**
     * @method POST
     * Cria um novo orçamento
     * <p>
     * O campo $instant do orçamento é preenchido com a data atual, 
     * então o novo orçamento é armazenado no BD
     * 
     * @param request a requisição é validada na classe StoreFormValidation
     * 
     * @return redirect Redireciona para a tela com a lista de orçamentos
     */
    public function store(StoreFormValidation $request)
    {
        $data = $request->all();
        $instant = date_create("", timezone_open("America/Bahia"));

        auth()->user()->estimates()->create(['client' => $data['client'],'estimatedValue' => $data['estimatedValue'],'description' => $data['description'],'instant' => $instant,]);

        return redirect('/orcamentos');
    }

    /**
     * Mostra os detalhes completos do orçamento
     * 
     * @param $estimate O orçamento que está sendo atualizado  
     * 
     * @return view Retorna a tela show com os detalhes deste orçamento
     */
    public function show(Estimate $estimate)
    {
        return view('estimates.show', compact('estimate'));
    }
    /**
     * Deleta um orçamento do BD
     * 
     * @param $estimate O orçamento que será deletado  
     * 
     * @return redirect Redireciona para a tela com a lista de orçamentos
     */
    public function destroy(Estimate $estimate)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        Estimate::destroy($estimate->id);
        return redirect('/orcamentos');
    }
}
