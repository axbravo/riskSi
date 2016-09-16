@extends('layout.admin')

@section('style')

@stop

@section('title')
	Nuevo Impacto
@stop

@section('content')
  <!-- Contenido-->
  <div class="row">
    <div class="col-sm-8">
      {!!Form::open(array('route' => 'impact.store','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Alcance</label>
          <div class="col-sm-10">
            {!!Form::textarea('schedule', null, ['class'=>'form-control','id'=>'inputEmail3','required'])!!}
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Costo</label>
          <div class="col-sm-10">
            {!!Form::textarea('cost',null,['class'=>'form-control','rows'=>5,'id'=>'cost','required'])!!}
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Valor</label>
          <div class="col-sm-10">
            {!!Form::number('value',null,['class'=>'form-control','rows'=>5,'id'=>'value','required'])!!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info">Guardar</button>
            <a href="{{action('RiskController@indexImpact')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
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