@extends('layout.admin')

@section('style')

@stop

@section('title')
	Editar Probabilidad

@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(array('route' => ['probability.update',$probability->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $probability->id)!!}


              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                  <input type="textarea" name="description" class="form-control" id="inputEmail3" placeholder="" value="{{$probability->description}}" required>
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Valor</label>
                <div class="col-sm-10">
                   <input type="number" name="value" class="form-control" id="inputEmail3" placeholder="" value="{{$probability->value}}" required>
                </div>
              </div>
              
 
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('riskmanager/probability')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>

            </form>
          </div>
        </div>

@stop

@section('javascript')

@stop