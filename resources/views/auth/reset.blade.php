@extends('layoutExternal')

@section('style')
	{!!Html::style('css/images.css')!!}
@stop

@section('title')
	Recuperar contraseña
@stop

@section('content')

	{!! Form::open(['url' => "/password/reset"]) !!}
	<input type="hidden" name="token" value="{{ $token }}">

	<div class="row"> 

	    <div class="col-md-12">
	         <div class="form-group col-sm-12">
	         	<div class="col-sm-5"><label class="control-label">Correo Electrónico</label></div>
	            <div class="col-sm-7"><input type="email" name="email" value="{{ old('email') }}"></div>
	         </div>
	    	
	         <div class="form-group col-sm-12">
	         	<div class="col-sm-5"> <label  class="control-label">Contraseña</label></div>
	        	<div class="col-sm-7"> <input type="password" name="password"></div>
	         </div>


			<div class="form-group col-sm-12">
				<div class="col-sm-5"> <label for="password" class="control-label">Recuperar contraseña</label></div>
				<div class="col-sm-7">
					<input type="password" name="password_confirmation">
				</div>
			</div>

	        <div class="form-group col-sm-12">
	        	 <br>
		         <button class="btn btn-info" type="submit">
					Resetear contraseña
	             </button>
	    	</div>

	     </div>


	</div>

	             <br>

	{!!Form::close() !!}
@stop

@section('javascript')

@stop