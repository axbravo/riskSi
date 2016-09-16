@extends('layout.admin')

@section('style')

@stop

@section('title')
	Actividades {{$project->name}}
@stop

@section('content')
        <!-- Contenido-->
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Actividad Precedente</th>
                <th>Fecha Inicial</th>
                <th>Fecha Final</th>
                <th>Duración</th>
                <th>Costo</th>
                <th>Costo mínimo</th>
                <th>Costo máximo</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
             @foreach($subactivities as $subactivity)
            <tr>
                <td>{{$subactivity->name}}</td>
                <td>{{$subactivity->description}}</td>
                <td>{{$subactivity->state}}</td>
                <td>{{$subactivity->dependence_id}}</td>
                <td>{{$subactivity->initialDate}}</td>
                <td>{{$subactivity->finalDate}}</td>
                <td>{{$subactivity->Duration}}</td>
                <td>{{$subactivity->cost}}</td>
                <td>{{$subactivity->minCost}}</td>
                <td>{{$subactivity->maxCost}}</td>
                <td class="button-center"><a class="btn btn-info" href={{route('project.edit', $subactivity->id)}} title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$subactivity->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$subactivity->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL -->
              <div class="modal fade"  id="deleteModal{{$subactivity->id}}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea eliminar la actividad?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                      
                    </div>
                    <div class="modal-footer">
                      <form method="post" action={{route('project.delete', $subactivity->id)}}>
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

        <div class="row">
          <div class="col-md-12 text-right">
            <a href="{{url('portmanager/project')}}" class="btn btn-info">Regresar</a>
          </div>
        </div>
 <html>
  <head>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);
    
     function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
    }

      var info = <?php echo $project->subactivities; ?>;

      function parentActivity(id){
        for(iterator in info){
          if(info[iterator].id==id) return iterator;
        }
      }
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');

        var maxyear=1000000000;
        var maxmonth=1000000000;
        var maxday=1000000000;
        var position=0;
        // For each orgchart box, provide the name, manager, and tooltip to show.
       for (key in info){
           var initialYear = parseInt(info[key].initialDate.substr(0,4));
           var initialMonth = parseInt(info[key].initialDate.substr(6,8));
           var initialDay = parseInt(info[key].initialDate.substr(8,10));
           if(maxyear>=initialYear){
            maxyear=initialYear;
            if(maxmonth>=initialMonth){
              maxmonth=initialMonth;
              if(maxday>initialDay){
                maxday=initialDay;
                position=key;
              }
            }
           } 
        }
         
        for (key in info){
           var initialYear = parseInt(info[key].initialDate.substr(0,4));
           var initialMonth = parseInt(info[key].initialDate.substr(6,8));
           var initialDay = parseInt(info[key].initialDate.substr(8,10));

           var finalYear = parseInt(info[key].finalDate.substr(0,4));
           var finalMonth = parseInt(info[key].finalDate.substr(6,8));
           var finalDay = parseInt(info[key].finalDate.substr(8,10));
           
           var d_id_activity=parentActivity(info[key].dependence_id);
           
           //Poner actividad inicial
            if(key!=position)
            data.addRows([[info[key].name, info[key].name,new Date(initialYear,initialMonth-1, initialDay),new Date(finalYear,finalMonth-1,finalDay),info[key].Duration,0,info[d_id_activity].name]]);
            else
             data.addRows([[info[key].name, info[key].name,new Date(initialYear,initialMonth-1, initialDay),new Date(finalYear,finalMonth-1,finalDay),info[key].Duration,0,null]]); 
          }
         var options = {
          height: 275,
          gantt: {
            criticalPathEnabled: true,
            criticalPathStyle: {
              stroke: '#e64a19',
              strokeWidth: 5
            }
          }

        };
        

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
      }
   </script>
    </head>
  <body>
     
    <div id="chart_div"></div>
  </form>
  </body>
</html>

        
@stop

@section('javascript')

@stop
