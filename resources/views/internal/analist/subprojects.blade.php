@extends('layout.admin')

@section('style')

@stop

@section('title')
	Actividades  
@stop

@section('content')
        <!-- Contenido-->
             <div class="col-sm-3">
                <hr style="margin:1px;">
                <p>{!!Form::text('state', null ,['class'=>'form-control', 'id'=>'search','placeholder' => 'Estado de actividad'])!!}</p>
            </div>
            <div class="col-sm-2">
            <p ><a class="btn btn-info" id = 'boton' >Buscar</a></p>
            </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Fecha Inicial</th>
                <th>Fecha Final</th>
                <th>Duración</th>
                <th>Costo</th>
                <th>Costo mínimo</th>
                <th>Costo máximo</th>
                <th>Editar</th>
            </tr>
             @foreach($subactivities as $subactivity)
            <tr>
                <td>{{$subactivity->name}}</td>
                <td>{{$subactivity->description}}</td>
                <td>{{$subactivity->state}}</td>
                <td>{{$subactivity->initialDate}}</td>
                <td>{{$subactivity->finalDate}}</td>
                <td>{{$subactivity->Duration}}</td>
                <td>{{$subactivity->cost}}</td>
                <td>{{$subactivity->minCost}}</td>
                <td>{{$subactivity->maxCost}}</td>
                <td class="button-center"><a class="btn btn-info" href={{route('activity.edit', $subactivity->id)}} title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
             </tr>
            @endforeach
        </table>


  

        
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