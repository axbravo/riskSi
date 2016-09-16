@extends('layout.admin')

@section('style')

@stop

@section('title')
	Analísis {{$project->name}} <!--Aca va el nombre del proyecto-->
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">

              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Tipo de Distribución</label>
                <div class="col-sm-10">
                   {!! Form::select('analist_id', $analist_list->toArray(), null, array('class' => 'form-control','id' => 'analist')) !!}
                </div>
              </div>
              <div class="form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Número de iteraciones</label>
               <div class="col-sm-10">
                 {!! Form::select('analist_id', $analist_list->toArray(), null, array('class' => 'form-control','id' => 'analist')) !!}
              </div>
             </div>
             <div class="form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Variable a analizar</label>
               <div class="col-sm-10">
                 {!! Form::select('analist_id', $analist_list->toArray(), null, array('class' => 'form-control','id' => 'analist')) !!}
              </div>
             </div>  
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <a href="{{url('admin/project/'.$project->id.'/analyse')}}"><button type="button" class="btn btn-info">Analizar</button></a>
                  <a href="{{action('ProjectController@index')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>
            </form>
          </div>
          <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
      
      google.charts.load('current', {'packages':['corechart']});    
      google.charts.setOnLoadCallback(drawChart);
 
      function drawChart() {
         var data = new google.visualization.DataTable(); 
       data.addColumn('Iteration', 'Result');
    //    var info = <?php echo $project->runCheckPlanRiskTrian($project->id,10); ?>;


          for (key in info){
            data.addRows([[info[key], info[key+2]],]);
            key=3*key+1;
          }

        var options = {
          title: 'Distribución Triangular de Costos',
          legend: { position: 'none' },
        };

        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
        chart.draw(data, options);

      }
    </script>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
        </div>

@stop

@section('javascript')

@stop