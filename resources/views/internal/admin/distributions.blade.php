@extends('layout.admin')

@section('style')
  {!!Html::style('css/images.css')!!}
@stop

@section('title')
	Tipo de Distribuciones
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          {!!Form::open(array('url' => 'admin/distribution' ,'id'=>'form','class'=>'form-horizontal'))!!}

        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
             <tbody id="fbody">
            @foreach($distributions as $distribution)
            <tr>
                <td>{{$distribution->name}}</td>
                <td class="button-center"><a class="btn btn-info" href="{{url('admin/distribution/'.$distribution->id.'/edit')}}" title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$distribution->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$distribution->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL -->
              <div class="modal fade"  id="deleteModal{{$distribution->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea eliminar "{{$distribution->name}}"?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                      
                    </div>
                    <div class="modal-footer">
                      <form method="post" action={{route('distribution.delete', $distribution->id)}}>
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-info">Sí</button>
                      </form>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
            </div>
            
            @endforeach
           </tbody>
        </table>
        {!!$distributions->render()!!}


@stop

@section('javascript')

@stop