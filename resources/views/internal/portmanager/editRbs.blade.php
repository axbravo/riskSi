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

          </div>
        </div>
    

@stop

@section('javascript')

@stop