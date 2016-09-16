@extends('layout.admin')

@section('style')

@stop

@section('title')
	Lista de Administradores
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
       @foreach($users as $user)

      <tr>
          <td>{{$user->lastname}}</td>
          <td>{{$user->name}}</td>
          <td>
            @if($user->di_type == config('constants.national'))
              DNI
            @else
              Carne de Extranjeria
            @endif
          </td>
          <td>{{$user->di}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->phone}}</td>

          <td>        
            <a class="btn btn-info" href="" data-toggle="modal" data-target="#edit{{$user->id}}" title="Detalles"><i class="glyphicon glyphicon-plus"></i></a>
          </td> 
          <td>
            <a class="btn btn-info" href="{{url('admin/admin/'.$user->id.'/edit')}}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a>
            <div class="modal fade" id="edit{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    
                    <h4 class="modal-title" id="myModalLabel">Detalle del Administrador</h4>
                  </div>
                  <div class="modal-body">
                    <h4>Nombre</h4>
                    {{$user->name.' '.$user->lastname}}
                    <h4>Direccion</h4>
                    {{$user->address}}
                    <h4>Documento Identidad</h4>
                    @if($user->di_type == config('constants.national'))
                    DNI
                    @else
                    Carnet de Extranjeria
                    @endif
                    <h4>Número de Documento</h4>
                    {{$user->di}}
                    <h4>Teléfono</h4>
                    {{$user->phone}}
                    <h4>Cumpleaños</h4>
                    {{$user->birthday}}
                  </div>



                  <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div> 
            <td>
              <a class="btn btn-info" href="" title="Eliminar" data-toggle="modal" data-target="#deleteModal{{$user->id}}"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
            <!-- MODAL -->
            
            <div class="modal fade"  id="deleteModal{{$user->id}}">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">¿Estas seguro que desea eliminar al administrador?</h4>
                  </div>
                  <div class="modal-body">
                    <h5 class="modal-title">Los cambios serán permanentes</h5>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                      <a class="btn btn-info" href="{{url('admin/admin/'.$user->id.'/delete')}}" title="Delete" >Sí</a>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
          </td>
      </tr>
      @endforeach    
  </table>

  {!!$users->render()!!}

@stop

@section('javascript')

@stop