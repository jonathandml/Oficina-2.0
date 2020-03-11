@extends('layouts.app')

@section('content')
<div class="container">
   <?php
      $date = date_create($estimate->instant);
   ?>

   <h3>Orçamento Nº {{ $estimate->id }}</h3>
   <hr>
   <div class="col-8 pt-3">
      <dl class="row">
         <dt class="col-sm-2">
            <label for="cliente"><p>Cliente</p></label>
         </dt>
         <dd class="col-sm-10">
            <p name="cliente">{{ $estimate->client}}</p>
         </dd>
         <dt class="col-sm-2">
            <label for="seller"><p>Vendedor</p></label>
         </dt>
         <dd class="col-sm-10">
            <p name="seller">{{ $estimate->user->name }}</p>
         </dd>
         <dt class="col-sm-2">
            <label for="date"><p>Data</p></label>
         </dt>
         <dd class="col-sm-10">
            <p name="date">{{ date_format($date,"d/m/Y") }}</p>
         </dd>
         <dt class="col-sm-2">
            <label for="time"><p>Hora</p></label>
         </dt>
         <dd class="col-sm-10">
            <p name="time">{{ date_format($date,"H:i") }}</p>
         </dd>
         <dt class="col-sm-2">
            <label for="estimatedValue"><p>Valor</p></label>
         </dt>
         <dd class="col-sm-10">
            <p name="estimatedValue">R$ {{ $estimate->estimatedValue }}</p>
         </dd>
         <dt class="col-sm-2">
            <label for="description"><p>Descrição</p></label>
         </dt>
         <dd class="col-sm-10">
            <p name="description">{{ $estimate->description }}</p>
         </dd>

      </dl>
   </div>
   <div class="pt-2">
      <a href="/orcamentos" class="ml-2 btn btn-dark">Voltar</a>
      @guest
      @else
      <a href="/orcamentos/{{ $estimate->id }}/edit" class="ml-2 btn btn-primary">Editar</a>
      <button class="btn btn-danger ml-2" data-estid={{$estimate->id}} data-toggle="modal" data-target="#delete">Deletar</button>
      @endguest
   </div>
</div>
<!--Modal para deletar-->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         
         <h4 class="modal-title text-center">Confirmar Deleção</h4>
       </div>
       <form action="/orcamentos/{{$estimate->id}}" method="post">
             {{method_field('delete')}}
             {{csrf_field()}}
          <div class="modal-body">
             <p class="text-center">
                Tem certeza que deseja deletar este orçamento?
             </p>
                <input type="hidden" name="estimate_id" id="est_id" value="">
 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Deletar</button>
          </div>
       </form>
     </div>
   </div>
 </div>

 <script>

   $('#delete').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget) 
       var est_id = button.data('estid') 
       var modal = $(this)
       modal.find('.modal-body #est_id').val(est_id);
 });
 </script>

@endsection