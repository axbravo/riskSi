@extends('layout.admin')

@section('style')

@stop

@section('title')
	Riesgos de Catálogo: {{$risk->name}}
@stop

@section('content')
        <!-- Contenido-->
        <div class="col-sm-12 text-right">
           <a class="btn btn-info" href={{route('task.check', $risk->id)}} title="Check" ><i class="glyphicon glyphicon-check"></i></a>
           <br> <br>
        </div>
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Importancia</th>
                <th>Factores</th>
                <th>Costo</th>
                <th>Duración</th>
                <th>Respuesta</th>
                <th>Editar</th>
                <th>Eliminar</th>
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
                <td class="button-center"><a class="btn btn-info" href="{{url('projectManager/task/'.$subrisk->id.'/responseplan')}}" title="Editar" ><i class="glyphicon glyphicon-file"></i></a>
                </td>
                <td class="button-center"><a class="btn btn-info" href="{{url('projectManager/task/'.$subrisk->id.'/edit')}}" title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$subrisk->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$subrisk->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL -->
              <div class="modal fade"  id="deleteModal{{$subrisk->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea eliminar el riesgo?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                      
                    </div>
                    <div class="modal-footer">
                      <form method="post" action={{route('task.delete', $subrisk->id)}}>
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
        </table>
        <div class="row" data-array="$risk->subrisks"> </div>
        <div class="row">
          <div class="col-md-12 text-right">
            <tr><td> <input id="arreglo" type="hidden" name="type" value=<?=$risk->subrisks?> ></td></tr>

            <a href="{{route('projectManager.task.index')}}" class="btn btn-info">Regresar</a>
          </div>
        </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    //  var infos =document.getElementById("arreglo").value;
      google.charts.load('current', {'packages':['treemap']});    
      google.charts.setOnLoadCallback(drawChart);
      var info = <?php echo $risk->subrisks; ?>;
      function drawChart() {
         var data = new google.visualization.DataTable(); 
       data.addColumn('string', 'Name');
        data.addColumn('string', 'Title');
        data.addColumn('number', 'Importance');
        data.addColumn('number', 'Impact');
         var info = <?php echo $risk->subrisks; ?>;


         var data = google.visualization.arrayToDataTable([
                       ['Riesgo', 'Categoria', 'Impacto', 'Importancia'],
                       ['Matriz',    null,                 0,                               0],
                       ['Importancia Alta',   'Matriz',             0,                               0],
                       ['Importancia Media',  'Matriz',             0,                               0],
                       ['Importancia Baja',   'Matriz',             0,                                0]
                       ]);
         var cantAlta=0; var cantModerado=0; var cantBaja=0;
         
          for (key in info){
            if(info[key].importance=='Riesgo Alto'){
            data.addRows([[info[key].name, 'Importancia Alta',20,0],]);
            cantAlta++;
            } 
          }
          for (key in info){
            if(info[key].importance=='Riesgo Moderado'){
            data.addRows([[info[key].name, 'Importancia Media',10,20],]);
            cantModerado++;
            } 
          }
          for (key in info){
            if(info[key].importance=='Riesgo Bajo'){
            data.addRows([[info[key].name, 'Importancia Baja',5,60],]);
            cantBaja++;
            } 
          }

        tree = new google.visualization.TreeMap(document.getElementById('chart_div'));

        tree.draw(data, {
          minColor: '#f00',
          midColor: '#FFFF00',
          maxColor: '#0d0',
          headerHeight: 15,
          fontColor: 'black',
          showScale: true
        });

      }
    </script>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
        
@stop

@section('javascript')

@stop
