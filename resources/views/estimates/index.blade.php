@extends('layouts.app')

@section('content')



<div class="container">

   
      <div class="d-flex justify-content-between align-items-baseline">
         <h1>Orçamentos</h3>
         @guest
         @else
         <a href="/orcamentos/create" class="btn btn-dark">Novo Orçamento</a>
         @endguest
      </div>
      <hr>
      <h4>Pesquisar Orçamento</h4>
      <div class="py-2">
         <form action="/search" method="get">
            <label for="seller" strong>Vendedor </label>
            <input type="text" name="seller">
            <label for="client">Cliente </label>
            <input type="text" name="client">
            <label for="starDate">Período de </label>
            <input type="date" name="startDate">
            <label for="endDate"> até </label>
            <input type="date" name="endDate">
            <button type="submit" class="btn btn-dark">Filtrar</button>
         </form>
      </div>
      <hr>
      <div>
         <table class="table table-hover">
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
               <tr data-href="/orcamentos/{{ $estimate->id }}" style="cursor: pointer;">
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

<script>
   document.addEventListener("DOMContentLoaded", () => {
      const rows = document.querySelectorAll("tr[data-href]");

      rows.forEach(row => {
         row.addEventListener("click", () => {
            window.location.href = row.dataset.href;
         });
      });
   });
</script>

@endsection