@extends('layout.admin')

@section('style')

@stop

@section('title')
  Editar Iteración
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
             {!!Form::open(array('route' => ['iteration.update',$iteration->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $iteration->id)!!}

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Valor</label>
                <div class="col-sm-10">
                  <input type="number" name="value" class="form-control" id="inputEmail3" placeholder="" value="{{$iteration->value}}" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{action('DistributionController@indexIter')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
          </div>
        </div>
    

@stop

@section('javascript')

@stop