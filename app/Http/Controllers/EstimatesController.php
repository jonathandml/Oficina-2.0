<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Estimate;
use SebastianBergmann\Environment\Console;

class EstimatesController extends Controller
{

    public function index(){
        $estimates = Estimate::whereNotNull('id')->latest()->paginate(10);
        return view('estimates.index', compact('estimates'));
    }

    public function search(Request $request){

        $aux = Estimate::whereNotNull('id')->get();

        $sellerName = $request->get('seller');
        if($sellerName != null){
            $sellers = User::where('name','like','%' . $sellerName . '%')->pluck('id');
            $aux = $aux->whereIn('user_id',$sellers);
        }

        $client  = $request->get('client');
        if($client != null){
            $clients = Estimate::where('client','like','%' . $client . '%')->pluck('id');
            $aux = $aux->whereIn('id',$clients);
        }
        
        $startDate = $request->get('startDate');
        if($startDate != null){
            $data = date_create($startDate);
            $this->console_log($data);
            $dates = Estimate::where('instant','>=',$data)->pluck('id');
            $aux = $aux->whereIn('id',$dates);

        }

        $endDate = $request->get('endDate');
        if($endDate != null){
            $data = date_create($endDate);
            date_time_set($data,23,59);
            $this->console_log($data);
            $dates = Estimate::where('instant','<=',$data)->pluck('id');
            $aux = $aux->whereIn('id',$dates);
        }

        $aux = $aux->pluck('id');
        
        $estimates = Estimate::whereIn('id',$aux)->latest()->paginate(1000);
        return view('estimates.index',['estimates' => $estimates]);
        
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

    function console_log( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
      }
}
