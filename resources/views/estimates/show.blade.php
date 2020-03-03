@extends('layouts.app')

@section('content')
<div class="container">
   <?php
      $date = date_create($estimate->instant);
   ?>

   <h3>Orçamento Nº {{ $estimate->id }}</h4>
   <hr>
   <div class="col-8 pt-3">
      <dl class="row">
         <dt class="col-sm-2">
            <label for="cliente"><h4>Cliente</h4></label>
         </dt>
         <dd class="col-sm-10">
            <h4 name="cliente">{{ $estimate->client}}</h4>
         </dd>
         <dt class="col-sm-2">
            <label for="seller"><h4>Vendedor</h4></label>
         </dt>
         <dd class="col-sm-10">
            <h4 name="seller">{{ $estimate->user->name }}</h4>
         </dd>
         <dt class="col-sm-2">
            <label for="date"><h4>Data</h4></label>
         </dt>
         <dd class="col-sm-10">
            <h4 name="date">{{ date_format($date,"d/m/Y") }}</h4>
         </dd>
         <dt class="col-sm-2">
            <label for="time"><h4>Hora</h4></label>
         </dt>
         <dd class="col-sm-10">
            <h4 name="time">{{ date_format($date,"H:i") }}</h4>
         </dd>
         <dt class="col-sm-2">
            <label for="estimatedValue"><h4>Valor</h4></label>
         </dt>
         <dd class="col-sm-10">
            <h4 name="estimatedValue">R$ {{ $estimate->estimatedValue }}</h4>
         </dd>
         <dt class="col-sm-2">
            <label for="description"><h4>Descrição</h4></label>
         </dt>
         <dd class="col-sm-10">
            <h4 name="description">{{ $estimate->description }}</h4>
         </dd>

      </dl>
   </div>
   <div class="pt-2">
      <a href="/orcamentos" class="ml-2 btn btn-dark">Voltar</a>
      @guest
      @else
      <a href="/orcamentos/{{ $estimate->id }}/edit" class="ml-2 btn btn-primary">Editar</a>
      <a href="#" class="ml-2 btn btn-danger">Deletar</a>
      @endguest
   </div>
</div>
@endsection