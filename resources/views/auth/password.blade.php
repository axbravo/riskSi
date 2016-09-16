@extends('layoutExternal')

@section('style')
	{!!Html::style('css/images.css')!!}
@stop

@section('title')
	Recuperar contraseña
@stop

@section('content')
	{!! Form::open(['url' => "/password/email"]) !!}
	{!! csrf_field() !!}

    <div class="text-center">
      <label for="password" class="col-sm-5 control-label">Correo Electrónico</label>
         <div class="col-sm-5">
           <input type="email" name="email" value="{{ old('email') }}">
         </div>

		<br> <br>
       <div class = "form-group">
          <div class="col-sm-10">
	         <button class="btn btn-info" type="submit">
                Enviar link de reseteo
             </button>
    	  </div>
       </div>



       <br> <br>

     </div>





	{!!Form::close() !!}
	
@stop

@section('javascript')

@stop