@extends('layout.admin')

@section('style')

@stop

@section('title')
	Analísis {{$project->name}} <!--Aca va el nombre del proyecto-->
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
             {!!Form::open(array('url' => 'projectManager/projects/'.$project->id.'/analyse','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              <div class="form-group">
                <label for="iterations" class="col-sm-2 control-label">Número de iteraciones</label>
                <div class="col-sm-10">
                {!! Form::select('iterations', $iteration_list->toArray(),null, array('class' => 'form-control','iterations' => 'iterations')) !!}
                </div>
               </div> 
                <label for="name" class="col-sm-2 control-label">Tipo de Distribución</label>
                <div class="col-sm-10">
                {!! Form::select('name', $typedistribution_list->toArray(),null, array('class' => 'form-control','name' => 'name')) !!}
                <br>
                </div>
                <label for="variable" class="col-sm-2 control-label">Variable a simular</label>
                <div class="col-sm-10">
               {!! Form::select('variable', $variable_list->toArray(),null, array('class' => 'form-control','variable' => 'variable')) !!}
                </div>
                 
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-info">Analizar</button></a>
                  <a href="{{action('ProjectController@index')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
            </form>
          </div>


@stop

@section('javascript')

@stop