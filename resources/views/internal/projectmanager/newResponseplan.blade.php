@extends('layout.admin')

@section('style')

@stop

@section('title')
  Nuevo Catalogo
@stop

@section('content')
  <!-- Contenido-->
  <div class="row">
    <div class="col-sm-8">
       {!!Form::open(array('url' => 'projectManager/task/new','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
        <div class="form-group" >
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
          <label class="col-sm-2" for="isSub">¿Riesgo?</label>
          <div class="col-sm-10">
            <input id="isSub" name="isSub" value="1" type="checkbox" @if (old('father_id') != '') checked @endif data-toggle="collapse" data-target="#subactivityForm" @if (count($risk_list)===0) disabled @endif>  
          </div>
        </div>
        <div id="subactivityForm" class="collapse form-group @if (old('father_id') != '') in @endif">
          
          <label class="col-sm-2" for="subrisks">Elija Catalogo</label>
          <div class="col-sm-10">
            {!! Form::select('father_id', $risk_list->toArray(), null, array('class' => 'form-control','id' => 'subrisks')) !!}
          <br>
          </div>
          <label class="col-sm-2" for="inputProbability">Probabilidad</label>
          <div class="col-sm-10">
          {!! Form::number('probability','', array('class' => 'form-control','id' => 'inputProbability','maxlength' => 50,'min' => '0')) !!}
          <br>
          </div>
          <label class="col-sm-2" for="inputCost">Costo estimado</label>
          <div class="col-sm-10">
            {!! Form::number('cost','', array('class' => 'form-control','id' => 'inputCost','maxlength' => 50,'min' => '0')) !!}
          <br>
          </div>
          <label class="col-sm-2" for="inputCost">Duracion</label>
          <div class="col-sm-10">
            {!! Form::number('duration','', array('class' => 'form-control','id' => 'inputCost','maxlength' => 50,'min' => '0')) !!}
          <br>
          </div>
          <label for="inputEmail3" class="col-sm-2 control-label">Factores que influyen</label>
          <div class="col-sm-10">
            {!!Form::textarea('factor',null,['class'=>'form-control','rows'=>5,'id'=>'factor','required'])!!}
            <br>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info">Guardar</button>
            <a href="{{action('RiskController@index')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
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