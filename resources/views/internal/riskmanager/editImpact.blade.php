@extends('layout.admin')

@section('style')

@stop

@section('title')
	Editar Impacto

@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(array('route' => ['impact.update',$impact->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $impact->id)!!}


              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Alcance</label>
                <div class="col-sm-10">
                  <input type="textarea" name="schedule" class="form-control" id="inputEmail3" placeholder="" value="{{$impact->schedule}}" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Costo</label>
                <div class="col-sm-10">
                   <input type="textarea" name="cost" class="form-control" id="inputEmail3" placeholder="" value="{{$impact->cost}}" required>
                </div>
              </div>
               <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Valor</label>
                <div class="col-sm-10">
                   <input type="number" name="value" class="form-control" id="inputEmail3" placeholder="" value="{{$impact->value}}" required>
                </div>
              </div>
              
 
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('riskmanager/impact')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>

            </form>
          </div>
        </div>

@stop

@section('javascript')

@stop