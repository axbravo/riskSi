@extends('layout.admin')

@section('style')

@stop

@section('title')
	Agregar trabajador
@stop

@section('content')
        <!-- Contenido-->
        <div class="row">
          <div class="col-sm-8">
             {!!Form::open(array('url' => 'admin/user/new','files'=>true,'id'=>'form','class'=>'form-horizontal'))!!}
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                   {!!Form::input('text','name', null ,['class'=>'form-control','id'=>'inputName','maxlength' => 50,'required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputLast" class="col-sm-2 control-label">Apellidos</label>
                <div class="col-sm-10">
                  {!!Form::input('text','lastname', null ,['class'=>'form-control','id'=>'inputLast','maxlength' => 50,'required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputPass" class="col-sm-2 control-label">Contraseña</label>
                <div class="col-sm-10">
                    {!!Form::input('password','password', null ,['class'=>'form-control','id'=>'inputPass','maxlength' => 30,'required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputType" class="col-sm-2 control-label">Tipo de documento</label>
                <div class="col-sm-10">
                  {!! Form::select('di_type', [
                     '1' => 'DNI',
                     '2' => 'Carnet de Extranjeria'], null, ['class'=>'form-control']
                  ) !!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputDi" class="col-sm-2 control-label">Documento de Identidad</label>
                <div class="col-sm-10">
                  {!!Form::input('number','di', null ,['class'=>'form-control','id'=>'inputDi','required','maxlength' => 8])!!} 
                </div>
              </div>
              <div class="form-group">
                <label for="inputAddress" class="col-sm-2 control-label">Dirección</label>
                <div class="col-sm-10">
                  {!!Form::input('text','address', null ,['class'=>'form-control','id'=>'inputAddress','maxlength' => 50,'required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputPhone" class="col-sm-2 control-label">Teléfono(s)</label>
                <div class="col-sm-10">
                  {!!Form::input('number','phone', null ,['class'=>'form-control','id'=>'inputPhone','required','maxlength' => 10,'min'=>0])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">E-mail(s)</label>
                <div class="col-sm-10">
                    {!!Form::input('text','email', null ,['class'=>'form-control','id'=>'inputEmai3','maxlength' => 30,'required'])!!}
                </div>
              </div>
              <div class="form-group">
                <label for="inputBirth" class="col-sm-2 control-label">Nacimiento</label>
                <div class="col-sm-10">
                    {!!Form::input('date','birthday', null ,['class'=>'form-control','id'=>'inputBirth','required'])!!}
                  <div class="col-sm-6" id="firefox" style="visibility: hidden">
                      Formato fecha: aaaaa-mm-dd
                  </div>                     
                </div>
              </div>
              <div class="form-group">
                <label for="inputRole" class="col-sm-2 control-label">Cargo</label>
                <div class="col-sm-10">
                {!!Form::select('role_id', ['4'=>'Administrador'], null, ['class'=>'form-control','required'])!!}
                </div>
              </div>
              <!--
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Imagen</label>
                <div class="col-sm-10">
                    {!!Form::input('file','image', null ,['class'=>'form-control','id'=>'inputEmai3','accept'=>'image/*'])!!}
                </div>
              </div> -->
               
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <!-- <a class="btn btn-info"  data-toggle="modal" data-target="#agregado">Guardar</a> -->
                  <a class="btn btn-info" type="button" href=""  title="Create"  data-toggle="modal" data-target="#saveModalUser">Guardar</a>
                  <!-- <button type="submit" class="btn btn-info">Guardar</button>-->
                  <a href="{{route('admin.home')}}"><button type="button" class="btn btn-info">Cancelar</button></a>
                </div>
              </div>


              <!-- MODAL -->
              <div class="modal fade"  id="saveModalUser">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">¿Estas seguro que desea agregar un nuevo usuario?</h4>
                    </div>
                    <div class="modal-body">
                      <h5 class="modal-title">Los cambios serán permanentes</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>                        
                        <button id = "botonModal" type="submit" class="btn btn-info">Sí</button>
                        <!--
                        <a class="btn btn-info" href="" title="Create" >Sí</a>
                        -->
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->

           {!!Form::close()!!}
          </div>
        </div>
@stop

@section('javascript')

  <script>
    function justNumbers(){
      var e = event || window.event;  
      var key = e.keyCode || e.which; 

      if (key < 48 || key > 57) { 
        if(key == 8 || key == 9 || key == 46){} //allow backspace and delete                                   
        else{
           if (e.preventDefault) e.preventDefault(); 
           e.returnValue = false; 
        }
      }
    }

      $("#botonModal").click(function(){
        $("#saveModalUser").modal('toggle');
    });


  </script>

<script>
$('document').ready(function () {

  if(navigator.userAgent.indexOf("Firefox")>-1 ) {
    console.log("its firefox");
    document.getElementById('firefox').style.visibility='visible';
  }
})
</script>     

@stop