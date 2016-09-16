@extends('layout.admin')

@section('style')

@stop

@section('title')
	Editar {{$project->name}} <!--Aca va el nombre del proyecto-->
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(array('route' => ['activity.update',$project->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $project->id)!!}


              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="" value="{{$project->name}}" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="description" text="{!!old('description')!!}" rows="5" required>{{$project->description}}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="inputinitialDate" class="col-sm-2 control-label">Fecha inicial</label>
                <div class="col-sm-10">
                    {!!Form::input('date','initialDate', null ,['class'=>'form-control','id'=>'inputinitialDate','required'])!!}
                  <div class="col-sm-6" id="firefox" style="visibility: hidden">
                      Formato fecha: aaaaa-mm-dd
                  </div>                     
                </div>
              </div>
              <div class="form-group">
                <label for="inputfinalDate" class="col-sm-2 control-label">Fecha final</label>
                <div class="col-sm-10">
                    {!!Form::input('date','finalDate', null ,['class'=>'form-control','id'=>'inputfinalDate','required'])!!}
                  <div class="col-sm-6" id="firefox" style="visibility: hidden">
                      Formato fecha: aaaaa-mm-dd
                  </div>                     
                </div>
              </div>  
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              @if($project->state =='Creado')
                <label class="radio-inline">{!!Form::radio('state','En Proceso' ,'true')!!}En Proceso</label>
                <label class="radio-inline">{!!Form::radio('state', 'Terminado')!!}Terminado</label> 

          @else
                <label class="radio-inline">{!!Form::radio('state','En Proceso' )!!}En Proceso</label>
                <label class="radio-inline">{!!Form::radio('state','Terminado','true' )!!}Terminado</label> 
          @endif
          </div>
                <label class="col-sm-2" for="inputCost">Costo estimado</label>
                <div class="col-sm-10">
                  {!! Form::number('cost','', array('class' => 'form-control','id' => 'inputCost','maxlength' => 50,'min' => '0')) !!}
                  <br>
                </div>
                <label class="col-sm-2" for="inputCost">Costo mínimo</label>
                <div class="col-sm-10">
                  {!! Form::number('minCost','', array('class' => 'form-control','id' => 'inputminCost','maxlength' => 50,'min' => '0')) !!}
                  <br>
                </div>
                <label class="col-sm-2" for="inputCost">Costo máximo</label>
                <div class="col-sm-10">
                  {!! Form::number('maxCost','', array('class' => 'form-control','id' => 'inputmaxCost','maxlength' => 50,'min' => '0')) !!}
                 <br>
                </div>
           </div>
              </div>     
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('analist/activity/subactivities')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
            </form>
          </div>
        </div>

@stop

@section('javascript')

@stop