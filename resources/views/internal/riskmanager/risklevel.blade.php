@extends('layout.admin')

@section('style')
  {!!Html::style('css/images.css')!!}
@stop

@section('title')
	Niveles de Riesgos
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
           {!!Form::open(array('url' => 'riskmanager/risklevel' ,'id'=>'form','class'=>'form-horizontal'))!!}
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Descripción</th>
                <th>Detalle</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
             <tbody id="fbody">
            @foreach($risklevels as $risklevel)
            <tr>
                <td>{{$risklevel->description}}</td>
                <td class="button-center"><a class="btn btn-info" data-toggle="modal" data-target="#detailModal{{$risklevel->id}}" href=""><i class="glyphicon glyphicon-plus"></i></a></td>
                <td class="button-center"><a class="btn btn-info" href="{{url('riskmanager/risklevel/'.$risklevel->id.'/edit')}}" title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$risklevel->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$risklevel->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL DELETE-->
              <div class="modal fade"  id="deleteModal{{$risklevel->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea eliminar el nivel de riesgo?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                      
                    </div>
                    <div class="modal-footer">
                      <form method="post" action={{route('risklevel.delete', $risklevel->id)}}>
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-info">Sí</button>
                      </form>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->

                          <!-- MODAL DETAIL -->
              <div class="modal fade"  id="detailModal{{$risklevel->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Detalle de {{$risklevel->description}}</h4>
                    </div>
                    <div class="modal-body">
                      <label>Valor mínimo probabilidad:</label>
                      <p>{{$risklevel->minProbability}}</p>
                      <label>Valor máximo probabilidad:</label>
                      <p>{{$risklevel->maxProbability}}</p>
                      <label>Valor mínimo impacto:</label>
                      <p>{{$risklevel->minImpact}}</p>
                      <label>Valor máximo impacto:</label>
                      <p>{{$risklevel->minImpact}}</p>            
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->
            </div>
            
            @endforeach
           </tbody>
        </table>
        {!!$risklevels->render()!!}

       <html>
  <head>
    

</html>



@stop

@section('javascript')

@stop