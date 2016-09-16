@extends('layout.admin')

@section('style')

@stop

@section('title')
	Categorías de {{$rbs->name}}
@stop

@section('content')
        <!-- Contenido-->
        <table class="table table-bordered table-striped">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
             @foreach($subrbss as $subrbs)
            <tr>
                <td>{{$subrbs->name}}</td>
                <td>{{$subrbs->description}}</td>
                <td class="button-center"><a class="btn btn-info" href={{route('rbs.edit', $subrbs->id)}} title="Editar" ><i class="glyphicon glyphicon-pencil"></i></a>
                </td> 
                <td class="button-center"><a id="delete {{$subrbs->id}}"class="btn btn-info" data-toggle="modal" data-target="#deleteModal{{$subrbs->id}}" href=""><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>

            <!-- MODAL -->
              <div class="modal fade"  id="deleteModal{{$subrbs->id}}">
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
                      <form method="post" action={{route('rbs.delete', $subrbs->id)}}>
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
            <a href="{{route('admin.rbs.index')}}" class="btn btn-info">Regresar</a>
          </div>
        </div>

 <html>
  <head>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
   
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);
      var info = <?php echo $rbs->subrbss; ?>;
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        var info = <?php echo $rbs->subrbss; ?>;
        // For each orgchart box, provide the name, manager, and tooltip to show.
         data.addRows([
           [{v:'Categorías', f:'Categorías </div>'},
           '']
        ]);
        for (key in info){
            data.addRows([[info[key].name, 'Categorías'],]);
          }
        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {allowHtml:true});
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
