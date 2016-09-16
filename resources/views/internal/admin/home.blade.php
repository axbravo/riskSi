@extends('layout.admin')

@section('style')

@stop

@section('title')
  Bienvenido admin
@stop

@section('content')
	<a  class="btn btn-info" href="{{url('admin/password')}}">Restaurar contraseña</a>
@stop

@section('javascript')

@stop

@section('content')
  <!-- Contenido-->