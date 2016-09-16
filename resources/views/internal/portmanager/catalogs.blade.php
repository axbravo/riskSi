@extends('layout.admin')

@section('style')
  {!!Html::style('css/images.css')!!}
@stop

@section('title')
	Catálogo de Riesgos
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
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
             <tbody id="fbody">
            @foreach($risks as $risk)
            <tr>
                <td>{{$risk->name}}</td>
                <td>{{$risk->description}}</td> 
                <td>{{$risk->state}}</td> <!--Aca debe de ir el estado-->
                <td class="button-center"><a class="btn btn-info" href="{{url('portmanager/itemrisk/'.$risk->id.'/subrisks')}}" title="Detalle" ><i class="glyphicon glyphicon-plus"></i></a>
                </td> 
                <td class="button-center"><a class="btn btn-info" href="{{url('portmanager/itemrisk/'.$risk->id.'/edit')}}" title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$risk->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$risk->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL -->
              <div class="modal fade"  id="deleteModal{{$risk->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea eliminar el catálogo {{$risk->name}}?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                      
                    </div>
                    <div class="modal-footer">
                      <form method="post" action={{route('itemrisk.delete', $risk->id)}}>
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
        {!!$risks->render()!!}

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