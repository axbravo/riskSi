@extends('layout.admin')

@section('style')

@stop

@section('title')
	Ideas para {{$risk->name}} 

@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(array('route' => ['risktask.update',$risk->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $risk->id)!!}
              <div class="form-group"> 
                <h4><b>Cultura de la Gestión de Riesgos:</b></h4>
                 <div class="checkbox">
                  <label><input type="checkbox" value="">Existe una cultura dentro de la organización que entiende y soporta las necesidades y beneficios de una Gestión de Riesgos efectiva?</label>
                  <br>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">La administración apoya la respuesta proactiva para identificar los riesgos?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Existen defensores de la gestión de riesgos?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Son los defensores de la gestión de riesgos apoyados por la Administración?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">El staff de la organización proporciona entrenamiento regular e información sobre la gestión de riesgos como los riesgos que enfrenta la empresa y las estrategias para como mitigarlo?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Es la información sobre los riesgos compartida a través de la organización y con otras organizaciones?</label>
                </div> 
                <br>
                <h4><b>Framework de la Gestión de Riesgos:</b></h4>
                <div class="checkbox">
                  <label><input type="checkbox" value="">La organización tiene un framework de la gestión de riesgos?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Está el framework de la gestión de riesgos claramente documentado?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Está el framework de la gestión de riesgos comunicado con el staff y entendido fácilmente por el staff?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Está el framework de la gestión de riesgos reflejado directamente en la tolerancia de la organización y el apetito del riesgo?</label>
                </div> 
                <div class="checkbox">
                  <label><input type="checkbox" value="">Está el framework de la gestión de riesgos integrado a través de todos los niveles de la organización y través de los procesos, operaciones, funciones y reportes?</label>
                </div> 
               </div> 
               <br>
                <h4><b>Procesos de la Gestión de Riesgos:</b></h4>


              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                 <a href="riskmanager/risktask/{id}/subrisks"></a> <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('riskmanager/risktask/'.$risk->id.'/subrisks')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>

            </form>
          </div>
        </div>

@stop

@section('javascript')

@stop