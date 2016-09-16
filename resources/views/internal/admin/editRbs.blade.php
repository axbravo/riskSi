@extends('layout.admin')

@section('style')

@stop

@section('title')
  Editar {{$rbs->name}} 
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
             {!!Form::open(array('route' => ['rbs.update',$rbs->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $rbs->id)!!}

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="" value="{{$rbs->name}}" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="description" text="{!!old('description')!!}" rows="5" required>{{$rbs->description}}</textarea>
                </div>
              </div>
              <div class="form-group">
              <label class="col-sm-2" for="isSub">¿Nivel 1?</label>
              <div class="col-sm-10">
                <input id="isSub" name="isSub" value="1" type="checkbox" @if (old('father_id') != '') checked @endif data-toggle="collapse" data-target="#subactivityForm" @if (count($rbs_list)===0) disabled @endif>  
              </div>
            </div>
            <div id="subactivityForm" class="collapse form-group @if (old('father_id') != '') in @endif">
              <label class="col-sm-2" for="subrbs">Elija Categoria</label>
              <div class="col-sm-10">
                {!! Form::select('father_id', $rbs_list->toArray(), null, array('class' => 'form-control','id' => 'subrbs')) !!}
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-info">Guardar</button>
                <a href="{{action('RbsController@index')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
              </div>
            </div>

          </div>
        </div>
    

@stop

@section('javascript')

@stop