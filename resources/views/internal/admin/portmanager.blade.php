@extends('layout.admin')

@section('style')

@stop

@section('title')
	Lista de Gestores de Proyectos
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
       @foreach($portmanagers as $portmanager)

      <tr>
          <td>{{$portmanager->lastname}}</td>
          <td>{{$portmanager->name}}</td>
          <td>
            @if($portmanager->di_type == config('constants.national'))
              DNI
            @else
              Carne de Extranjeria
            @endif
          </td>
          <td>{{$portmanager->di}}</td>
          <td>{{$portmanager->email}}</td>
          <td>{{$portmanager->phone}}</td>

          <td>        
            <a class="btn btn-info" href="" data-toggle="modal" data-target="#edit{{$portmanager->id}}" title="Detalles"><i class="glyphicon glyphicon-plus"></i></a>
          </td> 
          <td>
            <a class="btn btn-info" href="{{url('admin/portmanager/'.$portmanager->id.'/edit')}}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>
            <div class="modal fade" id="edit{{$portmanager->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                    <h4 class="modal-title" id="myModalLabel">Detalle del portmanagera</h4>
                  </div>
                  <div class="modal-body">
                    <h4>Nombre</h4>
                    {{$portmanager->name.' '.$portmanager->lastname}}
                    <h4>Direccion</h4>
                    {{$portmanager->address}}
                    <h4>Documento Identidad</h4>
                    @if($portmanager->di_type == config('constants.national'))
                    DNI
                    @else
                    Carnet de Extranjeria
                    @endif
                    <h4>Número de Documento</h4>
                    {{$portmanager->di}}
                    <h4>Teléfono</h4>
                    {{$portmanager->phone}}
                    <h4>Cumpleaños</h4>
                    {{$portmanager->birthday}}
                  </div>



                  <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div> 
            <td>
              <a class="btn btn-info" href="" title="Eliminar" data-toggle="modal" data-target="#deleteModal{{$portmanager->id}}"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
            <!-- MODAL -->
            
            <div class="modal fade"  id="deleteModal{{$portmanager->id}}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">¿Estas seguro que desea eliminar al portmanagera?</h4>
                  </div>
                  <div class="modal-body">
                    <h5 class="modal-title">Los cambios serán permanentes</h5>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                      <a class="btn btn-info" href="{{url('admin/portmanager/'.$portmanager->id.'/delete')}}" title="Delete" >Sí</a>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </td>
      </tr>
      @endforeach    
  </table>

  {!!$portmanagers->render()!!}

@stop

@section('javascript')

@stop