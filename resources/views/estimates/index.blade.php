@extends('layouts.app')

@section('content')
<div class="container">
   <div class="p-2">
      <a href="/orcamentos/create" class="btn btn-dark">Novo Orçamento</a>
   </div>
   
   <div>
      <table class="table table-striped table-hover">
         <thead class="thead-dark">
            <tr>
               <th scope="col">Cliente</th>
               <th scope="col">Vendedor</th>
               <th scope="col">Data</th>
               <th scope="col">Hora</th>
               <th scope="col">Valor</th>
               <th scope="col">Descrição</th>
              
            </tr>
         </thead>
         <tbody>
            @foreach($estimates as $estimate)
               <?php 
                  $date = date_create($estimate->instant);
               ?>
               <tr class="clickable-row" data-href="/orcamentos/create">
                  <td>{{ $estimate->client}}</td>
                  <td>{{ $estimate->user->name}}</td>
                  <td>{{ date_format($date,"d/m/Y")}}</td>
                  <td>{{ date_format($date,"H:i")}}</td>
                  <td>R$ {{ $estimate->estimatedValue }}</td>
                  <td>{{ $estimate->description}}</td>
                  
               </tr>
            @endforeach
         </tbody>
      </table>
</div>
   <div class="row">
      <div class="col-12 d-flex justify-content-center">
         {{ $estimates->links()}}
      </div>
   </div>
</div>

@endsection