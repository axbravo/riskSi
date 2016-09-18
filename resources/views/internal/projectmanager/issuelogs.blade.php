@extends('layout.admin')

@section('style')
  {!!Html::style('css/images.css')!!}
@stop

@section('title')
	Issue Log
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
            <div class="col-sm-3">
                <hr style="margin:1px;">
                <p>{!!Form::text('name', null ,['class'=>'form-control', 'id'=>'search','placeholder' => 'Nombre del catálogo'])!!}</p>
            </div>
          <div class="col-sm-2">
            <p ><a class="btn btn-info" id = 'boton' >Buscar</a></p>
        </div>

        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Detalle</th>
            </tr>
             <tbody id="fbody">
            @foreach($risks as $risk)
            <tr>
                <td>{{$risk->name}}</td>
                <td>{{$risk->description}}</td> 
                <td>{{$risk->state}}</td> <!--Aca debe de ir el estado-->
                <td class="button-center"><a class="btn btn-info" href="{{url('projectManager/issue/'.$risk->id.'/subrisks')}}" title="Detalle" ><i class="glyphicon glyphicon-plus"></i></a>
                </td> 
            </tr>
            @endforeach
           </tbody>
        </table>
    

       <html>
  <head>
    

</html>



@stop

@section('javascript')
<script>
$("#boton").click(function () {

    var rows = $("#fbody").find("tr").hide();
    var name = document.getElementById("search");
    var data = name.value;
    var search = data.toString().toLowerCase();
   
    if(search!=null && search != ''){ 
        $rows = rows;
            $rows.each(function(){
                var $this = $(this);
                $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
            });
            document.getElementById("error-msg1").style.visibility= "hidden";
            }
    else if(search==null || search != ''){
           $("#fbody").find("tr").show();
    }
     else document.getElementById("error-msg1").style.visibility= "visible";


});
</script>
@stop