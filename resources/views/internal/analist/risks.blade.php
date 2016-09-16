@extends('layout.admin')

@section('style')

@stop

@section('title')
	Listado de Riesgos
@stop

@section('content')
        <!-- Contenido-->
        <div class="col-sm-12 text-right">
       
           {!!Form::open(array('url' => 'analist/taskrisk' ,'id'=>'form','class'=>'form-horizontal'))!!}
           <br> <br>
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Oportunidad/Amenaza</th>
                <th>Importancia</th>
                <th>Factores</th>
                <th>Costo</th>
                <th>Duración</th>
                <th>Editar</th>
            </tr>
             @foreach($subrisks as $subrisk)
            <tr>
                <td>{{$subrisk->name}}</td>
                <td>{{$subrisk->description}}</td>
                <td>{{$subrisk->state}}</td>
                <td>{{$subrisk->type_risk}}</td>
                <td>{{$subrisk->importance}}</td>
                <td>{{$subrisk->factor}}</td>
                <td>{{$subrisk->cost}}</td>
                <td>{{$subrisk->duration}}</td>
                <td class="button-center"><a class="btn btn-info" href="{{url('analist/taskrisk/'.$subrisk->id.'/edit')}}" title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
               
            </tr>
            </div>
            @endforeach
        </table>


        
@stop

@section('javascript')

@stop
