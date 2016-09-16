@extends('layout.admin')

@section('style')

@stop

@section('title')
	Editar {{$risk->name}} 

@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
            {!!Form::open(array('route' => ['risktask.update',$risk->id],'files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              
              {!!Form::hidden('id', $risk->id)!!}


              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nombres</label>
                <div class="col-sm-10">
                  <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="" value="{{$risk->name}}" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="description" text="{!!old('description')!!}" rows="5" required>{{$risk->description}}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Estado</label>
              @if($risk->state =='Creado')
                <label class="radio-inline">{!!Form::radio('state','Activo' ,'true')!!}Activo</label>
                <label class="radio-inline">{!!Form::radio('state', 'Terminado')!!}Terminado</label> 

          @else
                <label class="radio-inline">{!!Form::radio('state','Activo' )!!}Activo</label>
                <label class="radio-inline">{!!Form::radio('state','Terminado','true' )!!}Terminado</label> 
          @endif
          </div>
              <div class="form-group @if ($risk->type == 1) hidden @endif">
                <label class="col-sm-2 control-label" for="isSub">Riesgo?</label>
                <div class="col-sm-10">
                  <input id="isSub" name="isSub" value="1" type="checkbox" data-toggle="collapse" data-target="#subactivityForm" checked disabled>  
               
                </div>
              </div>
              <div id="subactivityForm" class="collapse form-group @if ($risk->type == 2) in @endif">
                <label class="col-sm-2" for="risks">Elija Catálogo</label>
                <div class="col-sm-10">
                  {!! Form::select('father_id', $risk_list->toArray(), $risk->father_id, array('class' => 'form-control','id' => 'risks')) !!}
                  <br>
                </div>
                <label class="col-sm-2" for="subrisks">Categoría de Riesgo</label>
                <div class="col-sm-10">
                    {!! Form::select('rbs_id', $rbss_list->toArray(),null,['class' => 'form-control','required','id'=>'rbs_id']) !!}
                <br>
                </div> 
                <label class="col-sm-2" for="subactivities">Elija Responsable</label>
                <div class="col-sm-10">
                  {!! Form::select('riskresponsable_id', $riskresponsable_list->toArray(), null, array('class' => 'form-control','id' => 'riskresponsable')) !!}
                  <br>
                </div>             
                <div class="form-group"> 
                 <label for="inputEmail3" class="col-sm-2 control-label">Oportunidad o Amenaza</label>
                           @if($risk->state =='Creado')
                          <label type="submit" class="radio-inline">{!!Form::radio('type_risk','Oportunidad' ,'true')!!}Oportunidad</label>
                          <label  type="submit" class="radio-inline">{!!Form::radio('type_risk', 'Amenaza')!!}Amenaza</label> 

                    @else
                          <label  type="submit" class="radio-inline">{!!Form::radio('type_risk','Oportunidad' )!!}Oportunidad</label>
                          <label  type="submit" class="radio-inline">{!!Form::radio('type_risk','Amenaza','true' )!!}Amenaza</label> 
                    @endif
                    </div>

                 <div class="form-group">

                          <label for="inputEmail3" class="col-sm-2 control-label">Factores que influyen</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" name="factor" text="{!!old('factor')!!}" rows="5" required>{{$risk->factor}}</textarea>
                          </div>
                  </div>
                  <label for="name" class="col-sm-2 control-label">Nivel de Probabilidad</label>
                    <div class="col-sm-10">
                    {!! Form::select('levelprobability', $probability_list->toArray(),null, array('class' => 'form-control','levelprobability' => 'name')) !!}
                    <br>
                    </div>
                   <label for="name" class="col-sm-2 control-label">Nivel de Impacto</label>
                    <div class="col-sm-10">
                    {!! Form::select('impact', $impact_list->toArray(),null, array('class' => 'form-control','impact' => 'name')) !!}
                    <br>
                    </div> 

                <label class="col-sm-2" for="inputCost">Costo estimado</label>
                <div class="col-sm-10">
                  {!! Form::number('cost','', array('class' => 'form-control','id' => 'inputCost','maxlength' => 50,'min' => '0')) !!}
                  <br>
                </div>
                <label class="col-sm-2" for="inputProbability">Probabilidad(%)</label>
                <div class="col-sm-10">
                  {!! Form::number('probability','', array('class' => 'form-control','id' => 'inputProbability','maxlength' => 50,'min' => '0')) !!}
                  <br>
                </div>
                <label class="col-sm-2" for="inputDuration">Duracion</label>
                <div class="col-sm-10">
                  {!! Form::number('duration','', array('class' => 'form-control','id' => 'inputDuration','maxlength' => 50,'min' => '0')) !!}
                  <br>
                </div>
 
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-info">Guardar</button>
                  <a href="{{url('riskmanager/risktask')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>

            </form>
          </div>
        </div>

@stop

@section('javascript')

@stop