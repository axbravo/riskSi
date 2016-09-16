@extends('layout.admin')

@section('style')

@stop

@section('title')
	Nueva Probabilidad
@stop

@section('content')
  <!-- Contenido-->
  <div class="row">
    <div class="col-sm-8">
      {!!Form::open(array('route' => 'probability.store','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
          <div class="col-sm-10">
            {!!Form::textarea('description', null, ['class'=>'form-control','id'=>'inputEmail3','required'])!!}
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
            <a href="{{action('RiskController@indexProbability')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
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