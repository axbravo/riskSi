@extends('layout.admin')

@section('style')

@stop

@section('title')
	Lista de Analistas
@stop

@section('content')
  <!-- Contenido-->
  <table class="table table-bordered table-striped">
      <tr>
          <th>Apellidos</th>
          <th>Nombres</th>
          <th>Tipo de documento</th>
          <th>Documento Identidad</th>
          <th>Email</th>
          <th>Telefono</th>
          <th>Detalle</th>
          <th>Editar</th>
          <th>Eliminar</th>
      </tr>
       @foreach($analists as $analist)

      <tr>
          <td>{{$analist->lastname}}</td>
          <td>{{$analist->name}}</td>
          <td>
            @if($analist->di_type == config('constants.national'))
              DNI
            @else
              Carne de Extranjeria
            @endif
          </td>
          <td>{{$analist->di}}</td>
          <td>{{$analist->email}}</td>
          <td>{{$analist->phone}}</td>

          <td>        
            <a class="btn btn-info" href="" data-toggle="modal" data-target="#edit{{$analist->id}}" title="Detalles"><i class="glyphicon glyphicon-plus"></i></a>
          </td> 
          <td>
            <a class="btn btn-info" href="{{url('admin/analist/'.$analist->id.'/edit')}}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>
            <div class="modal fade" id="edit{{$analist->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                    <h4 class="modal-title" id="myModalLabel">Detalle del Analista</h4>
                  </div>
                  <div class="modal-body">
                    <h4>Nombre</h4>
                    {{$analist->name.' '.$analist->lastname}}
                    <h4>Direccion</h4>
                    {{$analist->address}}
                    <h4>Documento Identidad</h4>
                    @if($analist->di_type == config('constants.national'))
                    DNI
                    @else
                    Carnet de Extranjeria
                    @endif
                    <h4>Número de Documento</h4>
                    {{$analist->di}}
                    <h4>Teléfono</h4>
                    {{$analist->phone}}
                    <h4>Cumpleaños</h4>
                    {{$analist->birthday}}
                  </div>



                  <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div> 
            <td>
              <a class="btn btn-info" href="" title="Eliminar" data-toggle="modal" data-target="#deleteModal{{$analist->id}}"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
            <!-- MODAL -->
            
            <div class="modal fade"  id="deleteModal{{$analist->id}}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">¿Estas seguro que desea eliminar al analista?</h4>
                  </div>
                  <div class="modal-body">
                    <h5 class="modal-title">Los cambios serán permanentes</h5>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                      <a class="btn btn-info" href="{{url('admin/analist/'.$analist->id.'/delete')}}" title="Delete" >Sí</a>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </td>
      </tr>
      @endforeach    
  </table>

  {!!$analists->render()!!}

@stop

@section('javascript')

@stop