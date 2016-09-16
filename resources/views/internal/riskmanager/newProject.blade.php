@extends('layout.admin')

@section('style')

@stop

@section('title')
	Nuevo Proyecto
@stop

@section('content')
  <!-- Contenido-->
  <div class="row">
    <div class="col-sm-8">
      {!!Form::open(array('route' => 'project.store','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
        <div class="form-group" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
          <label for="inputEmail3" class="col-sm-2 control-label">Nombre</label>
          <div class="col-sm-10">
            {!!Form::text('name', null, ['class'=>'form-control','id'=>'inputEmail3','required'])!!}
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            {!!Form::textarea('description',null,['class'=>'form-control','rows'=>5,'id'=>'description','required'])!!}
          </div>
        </div>
        <div class="form-group">
                <label class="col-sm-2 control-label">Catálogo de riesgos</label>
                <div class="col-sm-6">
                    {!! Form::select('risk_id', $risks_list->toArray(),null,['class' => 'form-control','required','id'=>'risk_id']) !!}
                </div>

              </div>
         <div class="form-group">
                <label for="inputinitalDate" class="col-sm-2 control-label">Fecha inicio:</label>
                <div class="col-sm-10">
                    {!!Form::input('date','initialDate', null ,['class'=>'form-control','id'=>'inputinitalDate','required'])!!}
                  <div class="col-sm-6" id="firefox" style="visibility: hidden">
                      Formato fecha: aaaaa-mm-dd
                  </div>                     
                </div>
              </div>  
           <div class="form-group">
                <label for="inputfinalDate" class="col-sm-2 control-label">Fecha fin:</label>
                <div class="col-sm-10">
                    {!!Form::input('date','finalDate', null ,['class'=>'form-control','id'=>'inputfinalDate','required'])!!}
                  <div class="col-sm-6" id="firefox" style="visibility: hidden">
                      Formato fecha: aaaaa-mm-dd
                  </div>                     
                </div>
              </div> 
        <div class="form-group">
          <label class="col-sm-2" for="isSub">¿Actividad?</label>
          <div class="col-sm-10">
            <input id="isSub" name="isSub" value="1" type="checkbox" @if (old('father_id') != '') checked @endif data-toggle="collapse" data-target="#subactivityForm" @if (count($project_list)===0) disabled @endif>  
          </div>
        </div>
        <div id="subactivityForm" class="collapse form-group @if (old('father_id') != '') in @endif">
          <label class="col-sm-2" for="subactivities">Elija Proyecto</label>
          <div class="col-sm-10">
            {!! Form::select('father_id', $project_list->toArray(), null, array('class' => 'form-control','id' => 'subactivities')) !!}
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
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info">Guardar</button>
            <a href="{{action('ProjectController@index')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
          </div>
        </div>
      </form>
    </div>
  </div>
@stop

@section('javascript')
<script type="text/javascript">
  $("#isSub").isChecked()
</script>
@stop