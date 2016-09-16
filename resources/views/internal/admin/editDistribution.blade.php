@extends('layout.admin')

@section('style')

@stop

@section('title')
  Editar {{$distribution->name}} 
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
             {!!Form::open(array('route' => ['distribution.update',$distribution->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $distribution->id)!!}

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="" value="{{$distribution->name}}" required>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{action('DistributionController@index')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
          </div>
        </div>
    

@stop

@section('javascript')

@stop