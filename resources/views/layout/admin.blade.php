<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset($favicon) }}">
    <title>@yield('title') | {{$business_name}} - Sistema de Gestión de Riesgos</title>

    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/admin.css')!!}
    @yield('style')

</head>
<body>
    @extends('layout.topbar')
    
    <div class="container">
        <h1>@yield('title')</h1>
        <hr>
        @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        @yield('content')
    </div>
    <div class="container">
        <hr>
        <p><b>Andrea Bravo Rojas</b></p>
    </div>


    {!!Html::script('js/jQuery-2.1.4.min.js')!!}
    {!!Html::script('js/bootstrap.min.js')!!}
    {!!Html::script('js/jquery.validate.min.js')!!}
    {!!Html::script('js/messages_es_PE.js')!!}

    <script type="text/javascript">
    $(document).ready(function(){
        $('#form').validate({
        errorElement: "span",
        rules: {
        },
        highlight: function(element) {
            $(element).closest('.form-group')
            .removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $(element)
            .addClass('help-inline')
            .closest('.form-group')
            .removeClass('has-error').addClass('has-success');
            }
        });
        $('#yes').click(function(){
            $('.modal').modal('hide');
        });
    });
    </script>
    @yield('javascript')

</body>
</html>