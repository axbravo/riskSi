@extends('layout.admin')

@section('style')

@stop

@section('title')
	Cambiar contraseña
@stop

@section('content')
<div class="col-sm-6">
{!!Form::open(array('url' => 'admin/password','id'=>'form','class'=>'form-horizontal'))!!}
    <div class="form-group">
        <label for="password" class="col-sm-2 control-label">Contraseña</label>
        <div class="col-sm-10">
        {!! Form::password('password',  array('class' => 'form-control', 'required')) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="new_password" class="col-sm-2 control-label">Nueva Contraseña:</label>
        <div class="col-sm-10">
        {!! Form::password('new_password',  array('class' => 'form-control', 'required')) !!}
        <span class="help-block small">Ingrese mínimo 8 caracteres.</span>
        </div>
    </div>
    <div class="form-group">
        <label for="new_password_confirmation" class="col-sm-2 control-label">Confirme contraseña</label>
        <div class="col-sm-10">
        {!! Form::password('new_password_confirmation',  array('class' => 'form-control', 'required')) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-info']) !!}
        <a class="btn btn-info" href="{{ url ('admin') }}">Cancelar</a>
    </div>
{!! Form::close() !!}
</div>
{!! Form::close() !!}

@stop

@section('javascript')
@stop