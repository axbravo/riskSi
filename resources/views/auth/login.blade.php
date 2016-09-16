<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | {{$business_name}} </title>
    <link rel="shortcut icon" href="{{ $favicon }}">
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/designLogin.css')!!}
    <style type="text/css">
        .content button, .btn{
            background-color: #5bde79 ;
            border-color: #5bde79 ;
            margin: 10px 0;
            color: white;
            font-size: 1.1rem;
        }
        .btn:hover{
            background-color: #1f9b3c;
            border-color: #1f9b3c;
        }
        .content input{
          color: black;
          border: black;
        }
        .modal-body h4, .forgot{
          color: black;
        }
    </style>
</head>
<body>
    {!! Form::open(['url'=>'auth/login','method'=>'POST']) !!}
        {!! csrf_field() !!}

        <div class="content">
            <div class="title">Inicio de sesión</div>
            {!! Form::email('email', null, array('placeholder' => 'E-mail', 'required')) !!}

            {!! Form::password('password', array('placeholder' => 'Contraseña', 'required')) !!}
            <!--<a href="" data-toggle="modal" data-target="#myModal">Olvidaste tu contraseña?</a>-->
            <a href = "{{url('/password/email')}}" > Olvidaste tu contraseña? </a>
            <!-- Button trigger modal -->
            
            <button class="btn">Iniciar sesión</button>
            <!--<a href="{{url('/auth/register')}}" class="btn" data-target="#info" data-whatever="@mdo" style="width:100%">Registrarse</a>
            --><a href="{{URL::previous()}}" class="btn" role="button" data-target="#info" data-whatever="@mdo" style="width:100%">Regresar</a>
        </div>


        @include('errors.list')

    {!!Form::close()!!}

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4>Ingresa e-mail</h4>
                    {!! Form::email('copyOf', null, array('class'=>'forgot','placeholder' => 'E-mail', 'required')) !!}
                    <button type="button" class="btn btn-info" data-dismiss="modal" data-toggle="modal" data-target="#end" data-whatever="@mdo">Enviar</button>
                    <button type="button" class="btn btn-info" data-dismiss="modal" data-toggle="modal" data-target="#end" data-whatever="@mdo">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    {!!Html::script('js/jQuery-2.1.4.min.js')!!}
    {!!Html::script('js/bootstrap.min.js')!!}

</body>
</html>
