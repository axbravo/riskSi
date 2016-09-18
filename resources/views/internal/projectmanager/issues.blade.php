@extends('layout.admin')

@section('style')

@stop

@section('title')
	Issue log de Catálogo: {{$risk->name}}
@stop

@section('content')

        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>Importancia</th>
                <th>Factores</th>
                <th>Costo</th>
                <th>Duración</th>
            </tr>
             @foreach($subrisks as $subrisk)
            <tr>
                <td>{{$subrisk->name}}</td>
                <td>{{$subrisk->description}}</td>
                <td>{{$subrisk->type_risk}}</td>
                <td>{{$subrisk->importance}}</td>
                <td>{{$subrisk->factor}}</td>
                <td>{{$subrisk->cost}}</td>
                <td>{{$subrisk->duration}}</td>
            </tr>

            @endforeach
        </table>
        <div class="row" data-array="$risk->subrisks"> </div>
        <div class="row">
          <div class="col-md-12 text-right">
            <tr><td> <input id="arreglo" type="hidden" name="type" value=<?=$risk->subrisks?> ></td></tr>

            <a href="{{route('projectManager.issuelog.index')}}" class="btn btn-info">Regresar</a>
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
