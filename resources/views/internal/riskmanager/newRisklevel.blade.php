@extends('layout.admin')

@section('style')

@stop

@section('title')
	Nuevo Nivel de Riesgo
@stop

@section('content')
  <!-- Contenido-->
  <div class="row">
    <div class="col-sm-8">
      {!!Form::open(array('route' => 'risklevel.store','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            {!!Form::textarea('description', null, ['class'=>'form-control','id'=>'inputEmail3','required'])!!}
          </div>
        </div>
        <label class="col-sm-2" for="minprobability">Valor Mínimo Probabilidad</label>
          <div class="col-sm-10">
          {!! Form::select('minProbability', $probability_list->toArray(),null, array('class' => 'form-control','value' => 'minprobability')) !!}
          <br>
          </div>
        <label class="col-sm-2" for="maxprobability">Valor Máximo Probabilidad</label>
           <div class="col-sm-10">
           {!! Form::select('maxProbability', $probability_list->toArray(), null, array('class' => 'form-control','value' => 'maxprobability')) !!}
            <br>
          </div>
        <label class="col-sm-2" for="minimpact">Valor Mínimo Impacto</label>
            <div class="col-sm-10">
            {!! Form::select('minImpact', $impact_list->toArray(), null, array('class' => 'form-control','value' => 'minprobability')) !!}
             <br>
            </div>
        <label class="col-sm-2" for="maxprobability">Valor Máximo Impacto</label>
            <div class="col-sm-10">
            {!! Form::select('maxImpact', $impact_list->toArray(), null, array('class' => 'form-control','value' => 'maxprobability')) !!}
            <br>
            </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info">Guardar</button>
            <a href="{{action('RiskController@indexRisklevel')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
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