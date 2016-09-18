<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" >
	<title>@yield('title') | {{$business_name}}</title>
    {!!Html::style('css/bootstrap.min.css')!!}
    {!!Html::style('css/font-awesome.min.css')!!}
    {!!Html::style('css/style.css')!!}
    {!!Html::style('css/style-desktop.css')!!}
    {!!Html::script('js/jQuery-2.1.4.min.js')!!}

	@yield('style')

</head>
<body>
    @extends('layout.topbar')

	<div id="header">
		<div class="container">
			<!-- Logo -->

			<div id="logo">
				<h1 id="portada"><a href="{{url('/')}}">{{$business_name}}</a></h1>
			</div>

		</div>
	</div>

	<div class="container">
        <h1>@yield('title')</h1>
        <hr>

        @include('errors.list')

        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                {{ Session::get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        @endif
		@yield('content')
	</div>
</body>

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
    });
    </script>
	@yield('javascript')

</html>