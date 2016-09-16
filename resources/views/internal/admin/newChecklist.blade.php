@extends('layout.admin')

@section('style')

@stop

@section('title')
	Nuevo checklist
@stop

@section('content')
  <!-- Contenido-->
<div class="row">
          <div class="col-sm-8">
               {!!Form::open(array('route' => 'checklistItems.store','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Pregunta</label>
                <div class="col-sm-10">
                    {!!Form::text('question', null, ['class'=>'form-control','id'=>'inputEmail3','required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Riesgo</label>
                <div class="col-sm-10">
                    {!!Form::text('risk', null, ['class'=>'form-control','id'=>'inputEmail3','required'])!!}
                </div>
              </div>
              <label class="col-sm-2" for="subrisks">Categoría de Riesgo</label>
              <div class="col-sm-10">
                    {!! Form::select('rbs_id', $rbss_list->toArray(),null,['class' => 'form-control','required','id'=>'rbs_id']) !!}
              <br>
              </div> 
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{action('RiskController@indexCheck')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
          </div>
        </div>
    
@stop

@section('javascript')

@stop