@extends('layout.admin')

@section('style')

@stop

@section('title')
	Analísis Cuantitativo {{$project->name}} <!--Aca va el nombre del proyecto-->
@stop

@section('content')


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
      
      google.charts.load('current', {'packages':['corechart','bar']});    
      google.charts.setOnLoadCallback(drawChart);
      var percent = <?php echo $result_list; ?>;
      var cost = <?php echo $result; ?>;
      var min =  <?php echo $min; ?>;
      var max =  <?php echo $max; ?>;
      var mode = <?php echo $mode; ?>;
      var prommax= max;
      var prommin= min;
      function drawChart() {
        
          var data = new google.visualization.DataTable();
            data.addColumn('number', 'Valor');
            data.addColumn('number', 'Porcentaje');
            data.addColumn({type:'string', role:'style'});
          for (key in cost){
            if(cost[key]<prommin){
            data.addRows([[parseInt(cost[key]), percent[key],"green"]]);
            }
            else if(cost[key]>=prommax){
            data.addRows([[parseInt(cost[key]), percent[key],"red"]]);
            }
            else if(cost[key]>prommin && cost[key]<prommax){
            data.addRows([[parseInt(cost[key]), percent[key], "blue"]]);
            }
          }
          
          /*
          var dataArray=[['Valor', 'Porcentaje',{ role: 'style' }]];
          
          for (key in cost){
            if(cost[key]<=min){
            dataArray.push([[cost[key], percent[key], "green"]]);
            }
            else if(cost[key]>=max){
            dataArray.push([[cost[key], percent[key], "red"]]);
            }
            else if(cost[key]>min && cost[key]<max){
            dataArray.push([[cost[key], percent[key], "blue"]]);
            }
          }
             var data = new google.visualization.arrayToDataTable(dataArray);
          */
         

        var options = {
          title: 'Distribución de Probabilidad',
          width: 900,
          height: 700,
          bar: {groupWidth: "90%"},
          legend: { position: "none" },
          /*
          hAxis: {
      ticks: [-1, -0.75, -0.5, -0.25, 0, 0.25, 0.5, 0.75, 1]
    },*/
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);

      }
    </script>
    <div id="chart_div" style="width: 900px; height: 200px;"></div>
    <a href="{{url('projectManager/projects/'.$project->id.'/analyse')}}"><button type="button" class="btn btn-info">Regresar</button></a>
    </div>

     

@stop

@section('javascript')

@stop