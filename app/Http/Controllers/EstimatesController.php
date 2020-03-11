<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Estimate;
use App\Http\Requests\StoreFormValidation;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Auth;

class EstimatesController extends Controller
{

    public function index()
    {
        $estimates = Estimate::whereNotNull('id')->latest()->paginate(5);
        return view('estimates.index', compact('estimates'));
    }

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

    public function edit(Estimate $estimate)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        return view('estimates.update', compact('estimate'));
    }

    public function update(Estimate $estimate, StoreFormValidation $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $estimate->update($request->all());
        return redirect("/orcamentos");
    }

    public function create()
    {
        return view('estimates.create');
    }

    public function store(StoreFormValidation $request)
    {
        $data = $request->all();
        $instant = date_create("", timezone_open("America/Bahia"));

        auth()->user()->estimates()->create(['client' => $data['client'],'estimatedValue' => $data['estimatedValue'],'description' => $data['description'],'instant' => $instant,]);

        return redirect('/orcamentos');
    }

    public function show(Estimate $estimate)
    {
        return view('estimates.show', compact('estimate'));
    }

    public function destroy(Estimate $estimate)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        Estimate::destroy($estimate->id);
        return redirect('/orcamentos');
    }
}
