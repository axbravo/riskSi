@extends('layout.admin')

@section('style')
  {!!Html::style('css/images.css')!!}
@stop

@section('title')
	Valor de Iteraciones
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          {!!Form::open(array('url' => 'admin/iteration' ,'id'=>'form','class'=>'form-horizontal'))!!}
           
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Valor</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
             <tbody id="fbody">
            @foreach($iterations as $iteration)
            <tr>
                <td>{{$iteration->value}}</td>
                <td class="button-center"><a class="btn btn-info" href="{{url('admin/iteration/'.$iteration->id.'/edit')}}" title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$iteration->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$iteration->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL -->
              <div class="modal fade"  id="deleteModal{{$iteration->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea eliminar la iteración?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                      
                    </div>
                    <div class="modal-footer">
                      <form method="post" action={{route('iteration.delete', $iteration->id)}}>
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
        {!!$iterations->render()!!}


@stop

@section('javascript')

@stop