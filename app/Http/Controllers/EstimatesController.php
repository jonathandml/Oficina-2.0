<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Estimate;

class EstimatesController extends Controller
{
    public function index(){
        $estimates = Estimate::whereNotNull('id')->latest()->paginate(10);
        return view('estimates.index', compact('estimates'));
    }

    public function create(){
        return view('estimates.create');
    }

    public function store(){
        $data = request()->validate([
            'client' => 'required',
            'estimatedValue' => ['required','numeric'],
            'description' => ['required']
        ]);
        $instant = date_create("",timezone_open("America/Bahia"));

        auth()->user()->estimates()->create([
            'client' => $data['client'],
            'estimatedValue' => $data['estimatedValue'],
            'description' => $data['description'],
            'instant' => $instant,
        ]);

        return redirect('/orcamentos');
    }

    public function show(Estimate $estimate){
        return view('estimates.show', compact('estimate'));
    }
}
