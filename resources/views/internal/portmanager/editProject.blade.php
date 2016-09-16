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
            {!!Form::open(array('route' => ['project.update',$project->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
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
          <div class="form-group">
                <label class="col-sm-2 control-label">Catálogo de riesgos</label>
                <div class="col-sm-6">
                    {!! Form::select('risk_id', $risks_list->toArray(),null,['class' => 'form-control','required','id'=>'risk_id']) !!}
                </div>

              </div>

              <div class="form-group @if ($project->type == 2) hidden @endif">
              <label class="col-sm-2" for="project">Elija Responsable</label>
                <div class="col-sm-10">
                  {!! Form::select('projectmanager_id', $projectmanager_list->toArray(), null, array('class' => 'form-control','id' => 'projectmanager')) !!}
                  <br>
                </div>
              </div>

              <div class="form-group @if ($project->type == 1) hidden @endif">
                <label class="col-sm-2" for="isSub">Actividad?</label>
                <div class="col-sm-10">
                  <input id="isSub" name="isSub" value="1" type="checkbox" data-toggle="collapse" data-target="#subactivityForm" checked disabled>  
                </div>
              </div>
              <div id="subactivityForm" class="collapse form-group @if ($project->type == 2) in @endif">
                <label class="col-sm-2" for="subactivity">Elija Proyecto</label>
                <div class="col-sm-10">
                  {!! Form::select('father_id', $project_list->toArray(), $project->father_id, array('class' => 'form-control','id' => 'subactivity','type==1')) !!}
                  <br>
                </div>
                <label class="col-sm-2" for="subactivities">Elija Responsable</label>
                <div class="col-sm-10">
                  {!! Form::select('analist_id', $analist_list->toArray(), null, array('class' => 'form-control','id' => 'analist')) !!}
                  <br>
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
                <label class="col-sm-2" for="subactivities">Actividad Precedente</label>
                <div class="col-sm-10">
                  <input id="isSubA" name="isSubA" value="1" type="checkbox" @if (old('dependence_id') != '') checked @endif data-toggle="collapse" data-target="#dependenceForm" @if (count($project_list)===0) disabled @endif>
                <br><br><br>
                </div>
                <div id="dependenceForm" class="collapse form-group @if (old('dependence_id') != '') in @endif">
               
                <label class="col-sm-2" for="subactivities">Elija Actividad Precedente</label>
                <div class="col-sm-10">
                  {!! Form::select('dependence_id', $activities_list->toArray(), null, array('class' => 'form-control','id' => 'subactivities')) !!}
                  <br>
                </div>
                </div>
                <div id="dependenceForm" class="@if (old('dependence_id') == '')$project->dependence_id=null in @endif">
                      
                </div>
              </div>
           
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('portmanager/project')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
            </form>
          </div>
        </div>

@stop

@section('javascript')

@stop